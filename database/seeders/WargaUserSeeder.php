<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WargaUserSeeder extends Seeder
{
    public function run(): void
    {
        $warga = Warga::where('nik', '3275012304880001')->first();

        if (! $warga) {
            return;
        }

        $user = User::updateOrCreate(
            ['email' => 'warga@rtku.id'],
            [
                'name' => $warga->nama_lengkap,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'warga',
            ]
        );

        $warga->update(['user_id' => $user->id]);
    }
}
