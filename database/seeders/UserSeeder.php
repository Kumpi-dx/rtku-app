<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ketua@rtku.id'],
            [
                'name' => 'H. Bambang S.',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'pengurus',
            ]
        );

        User::updateOrCreate(
            ['email' => 'bendahara@rtku.id'],
            [
                'name' => 'Ahmad Dahlan',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'pengurus',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sekretaris@rtku.id'],
            [
                'name' => 'Siti Rahmawati',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'pengurus',
            ]
        );
    }
}
