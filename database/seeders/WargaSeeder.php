<?php

namespace Database\Seeders;

use App\Models\Warga;
use Illuminate\Database\Seeder;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nik' => '3275012304880001',
                'nama_lengkap' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'no_telp' => '0812-3456-7890',
                'pekerjaan' => 'Karyawan Swasta',
                'alamat' => 'Jl. Sukamaju No. 12',
                'status_domisili' => 'Tetap',
                'status_perkawinan' => 'Kawin',
            ],
            [
                'nik' => '3275016508900003',
                'nama_lengkap' => 'Siti Rahmawati',
                'jenis_kelamin' => 'Perempuan',
                'no_telp' => '0813-9876-5432',
                'pekerjaan' => 'Wiraswasta',
                'alamat' => 'Jl. Sukamaju No. 15',
                'status_domisili' => 'Tetap',
                'status_perkawinan' => 'Kawin',
            ],
            [
                'nik' => '3275011201950002',
                'nama_lengkap' => 'Ahmad Dahlan',
                'jenis_kelamin' => 'Laki-laki',
                'no_telp' => '0857-1122-3344',
                'pekerjaan' => 'PNS',
                'alamat' => 'Jl. Sukamaju No. 04',
                'status_domisili' => 'Kontrak',
                'status_perkawinan' => 'Kawin',
            ],
        ];

        foreach ($data as $item) {
            Warga::updateOrCreate(['nik' => $item['nik']], $item);
        }
    }
}
