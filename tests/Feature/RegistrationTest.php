<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers new accounts as warga with a linked warga profile', function () {
    $response = $this->post(route('register'), [
        'nama_lengkap' => 'Warga Uji',
        'nik' => '3275010101010101',
        'email' => 'wargauji@example.com',
        'no_telp' => '081234567890',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('portal.index'));

    $user = User::where('email', 'wargauji@example.com')->firstOrFail();

    expect($user->role)->toBe('warga');
    expect($user->isWarga())->toBeTrue();
    expect($user->isPengurus())->toBeFalse();
    expect($user->warga)->not->toBeNull();
    expect($user->warga->nik)->toBe('3275010101010101');

    $this->assertAuthenticatedAs($user);
    $this->get(route('warga.index'))->assertRedirect(route('portal.index'));
});
