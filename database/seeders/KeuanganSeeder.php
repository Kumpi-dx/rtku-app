<?php

namespace Database\Seeders;

use App\Models\KategoriKeuangan;
use App\Models\Keuangan;
use Illuminate\Database\Seeder;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = KategoriKeuangan::pluck('id', 'nama');

        $items = [
            ['kategori' => 'Iuran Bulanan', 'keterangan' => 'Iuran Kebersihan & Keamanan Budi Santoso', 'nominal' => 100000, 'tipe' => 'pemasukan', 'tanggal' => now()->startOfMonth()],
            ['kategori' => 'Donasi Warga', 'keterangan' => 'Donasi perbaikan pos ronda', 'nominal' => 500000, 'tipe' => 'pemasukan', 'tanggal' => now()->subDays(5)],
            ['kategori' => 'Operasional Lingkungan', 'keterangan' => 'Pembelian Lampu Jalan Gang 3', 'nominal' => 350000, 'tipe' => 'pengeluaran', 'tanggal' => now()->subDays(8)],
            ['kategori' => 'Perbaikan Sarana', 'keterangan' => 'Perbaikan selokan RT', 'nominal' => 750000, 'tipe' => 'pengeluaran', 'tanggal' => now()->subMonth()],
            ['kategori' => 'Iuran Bulanan', 'keterangan' => 'Iuran bulanan warga periode lalu', 'nominal' => 2500000, 'tipe' => 'pemasukan', 'tanggal' => now()->subMonth()],
            ['kategori' => 'Acara Warga', 'keterangan' => 'Konsumsi rapat bulanan', 'nominal' => 200000, 'tipe' => 'pengeluaran', 'tanggal' => now()->subMonths(2)],
        ];

        foreach ($items as $item) {
            Keuangan::updateOrCreate(
                ['keterangan' => $item['keterangan'], 'tanggal' => $item['tanggal']->toDateString()],
                [
                    'kategori_keuangan_id' => $kategoris[$item['kategori']],
                    'nominal' => $item['nominal'],
                    'tipe' => $item['tipe'],
                    'user_id' => null,
                ]
            );
        }
    }
}
