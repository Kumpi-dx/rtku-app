<?php

namespace Database\Seeders;

use App\Models\KategoriKeuangan;
use Illuminate\Database\Seeder;

class KategoriKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Iuran Bulanan', 'tipe' => 'pemasukan'],
            ['nama' => 'Donasi Warga', 'tipe' => 'pemasukan'],
            ['nama' => 'Sumbangan Acara', 'tipe' => 'pemasukan'],
            ['nama' => 'Operasional Lingkungan', 'tipe' => 'pengeluaran'],
            ['nama' => 'Perbaikan Sarana', 'tipe' => 'pengeluaran'],
            ['nama' => 'Acara Warga', 'tipe' => 'pengeluaran'],
        ];

        foreach ($items as $item) {
            KategoriKeuangan::updateOrCreate(['nama' => $item['nama']], $item);
        }
    }
}
