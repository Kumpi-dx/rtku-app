<?php

namespace Database\Seeders;

use App\Models\Iuran;
use App\Models\Warga;
use Illuminate\Database\Seeder;

class IuranSeeder extends Seeder
{
    public function run(): void
    {
        $wargas = Warga::orderBy('id')->get();
        $statuses = ['Lunas', 'Lunas', 'Belum Lunas'];

        foreach ($wargas as $index => $warga) {
            for ($month = 0; $month < 3; $month++) {
                $periode = now()->startOfMonth()->subMonths($month)->format('Y-m');
                $status = $statuses[($index + $month) % count($statuses)];

                Iuran::updateOrCreate(
                    ['warga_id' => $warga->id, 'periode' => $periode],
                    [
                        'jumlah' => 100000,
                        'status' => $status,
                        'tanggal_bayar' => $status === 'Lunas' ? now()->startOfMonth()->subMonths($month)->addDays(3) : null,
                        'user_id' => null,
                    ]
                );
            }
        }
    }
}
