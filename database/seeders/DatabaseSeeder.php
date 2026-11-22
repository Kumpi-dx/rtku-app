<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WargaSeeder::class,
            WargaUserSeeder::class,
            KategoriKeuanganSeeder::class,
            SuratSeeder::class,
            KeuanganSeeder::class,
            IuranSeeder::class,
            PengumumanSeeder::class,
        ]);
    }
}
