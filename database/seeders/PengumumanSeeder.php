<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'judul' => 'Kerja Bakti Massal Sambut Musim Hujan',
                'kategori' => 'Kerja Bakti',
                'isi' => 'Diimbau kepada seluruh warga RT 005 untuk hadir melaksanakan pembersihan selokan utama demi mencegah banjir.',
                'tanggal_mulai' => now()->addDays(2)->toDateString(),
                'waktu_mulai' => '07:00',
                'waktu_selesai' => '10:00',
                'lokasi' => 'Lapangan RT',
                'is_publik' => true,
            ],
            [
                'judul' => 'Jadwal Ronda Siskamling Terbaru',
                'kategori' => 'Keamanan',
                'isi' => 'Jadwal ronda malam untuk periode bulan depan telah diterbitkan. Harap cek grup WhatsApp resmi RT.',
                'tanggal_mulai' => now()->addDays(7)->toDateString(),
                'waktu_mulai' => '21:00',
                'waktu_selesai' => '04:00',
                'lokasi' => 'Pos Ronda Utama',
                'is_publik' => true,
            ],
            [
                'judul' => 'Rapat Bulanan Pengurus RT',
                'kategori' => 'Rapat',
                'isi' => 'Rapat koordinasi pengurus RT membahas program kerja dan laporan keuangan bulanan.',
                'tanggal_mulai' => now()->addDays(9)->toDateString(),
                'waktu_mulai' => '19:30',
                'waktu_selesai' => '21:00',
                'lokasi' => 'Rumah Ketua RT',
                'is_publik' => true,
            ],
        ];

        foreach ($items as $item) {
            Pengumuman::updateOrCreate(['judul' => $item['judul']], $item);
        }
    }
}
