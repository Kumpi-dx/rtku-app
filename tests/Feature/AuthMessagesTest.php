<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows an error message when login credentials are wrong', function () {
    $response = $this->from(route('login'))->followingRedirects()->post(route('login'), [
        'email' => 'salah@example.com',
        'password' => 'salah-sekali',
    ]);

    $response->assertOk()
        ->assertSee('Email atau kata sandi salah.')
        ->assertSee('value="salah@example.com"', false);
});

it('shows indonesian validation messages on failed registration', function () {
    $response = $this->from(route('register'))->followingRedirects()->post(route('register'), [
        'nama_lengkap' => '',
        'nik' => '123',
        'email' => 'bukan-email',
        'password' => 'pendek',
        'password_confirmation' => 'beda',
    ]);

    $response->assertOk()
        ->assertSee('Periksa kembali data Anda:')
        ->assertSee('Nama lengkap wajib diisi.')
        ->assertSee('NIK harus terdiri dari 16 digit angka.')
        ->assertSee('Format email tidak valid.')
        ->assertSee('Kata sandi minimal 8 karakter.');
});
