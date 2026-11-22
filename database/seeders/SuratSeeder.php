<?php

namespace Database\Seeders;

use App\Models\Surat;
use App\Models\Warga;
use Illuminate\Database\Seeder;

class SuratSeeder extends Seeder
{
    public function run(): void
    {
        $wargas = Warga::orderBy('id')->take(3)->get();

        $items = [
            ['jenis_surat' => 'Surat Keterangan Domisili', 'keperluan' => 'Pembukaan Rekening Bank', 'status' => 'Pending', 'urutan' => '012'],
            ['jenis_surat' => 'Surat Keterangan Tidak Mampu', 'keperluan' => 'Beasiswa Sekolah', 'status' => 'Disetujui', 'urutan' => '011'],
            ['jenis_surat' => 'Surat Keterangan Usaha', 'keperluan' => 'Pengajuan Kredit Usaha', 'status' => 'Diproses', 'urutan' => '010'],
        ];

        $year = now()->format('Y');
        $index = 0;

        foreach ($wargas as $warga) {
            $item = $items[$index % count($items)];
            $noSurat = sprintf('470/%s/RT05/%s', $item['urutan'], $year);

            Surat::updateOrCreate(
                ['no_surat' => $noSurat],
                [
                    'warga_id' => $warga->id,
                    'jenis_surat' => $item['jenis_surat'],
                    'keperluan' => $item['keperluan'],
                    'status' => $item['status'],
                    'tanggal_pengajuan' => now()->subDays($index + 1),
                    'tanggal_disetujui' => $item['status'] === 'Disetujui' ? now()->subDays($index) : null,
                    'ditandatangani_oleh' => $item['status'] === 'Disetujui' ? 'H. Bambang S.' : null,
                ]
            );

            $index++;
        }
    }
}
