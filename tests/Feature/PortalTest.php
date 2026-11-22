<?php

use App\Models\Surat;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->wargaUser = User::where('email', 'warga@rtku.id')->firstOrFail();
    $this->pengurus = User::where('email', 'ketua@rtku.id')->firstOrFail();
});

it('renders all portal pages for a warga', function () {
    $this->actingAs($this->wargaUser);

    $this->get(route('portal.index'))->assertOk();
    $this->get(route('portal.profil'))->assertOk();
    $this->get(route('portal.iuran'))->assertOk();
    $this->get(route('portal.surat'))->assertOk();
    $this->get(route('portal.surat.create'))->assertOk();
    $this->get(route('portal.pengumuman'))->assertOk();
    $this->get(route('portal.agenda'))->assertOk();
});

it('redirects warga away from the admin dashboard', function () {
    $this->actingAs($this->wargaUser)
        ->get(route('dashboard'))
        ->assertRedirect(route('portal.index'));
});

it('blocks warga from admin modules', function () {
    $this->actingAs($this->wargaUser)
        ->get(route('warga.index'))
        ->assertRedirect(route('portal.index'));
});

it('blocks pengurus from the warga portal', function () {
    $this->actingAs($this->pengurus)
        ->get(route('portal.index'))
        ->assertRedirect(route('dashboard'));
});

it('keeps a pengurus account with a warga record on the admin dashboard', function () {
    $bendahara = User::where('email', 'bendahara@rtku.id')->firstOrFail();

    $bendahara->warga()->create([
        'nik' => '3275019999999999',
        'nama_lengkap' => 'Ahmad Dahlan',
        'jenis_kelamin' => 'Laki-laki',
        'status_domisili' => 'Tetap',
    ]);

    expect($bendahara->fresh()->warga)->not->toBeNull();

    $this->actingAs($bendahara)
        ->get(route('dashboard'))
        ->assertOk();
});

it('lets a warga submit a surat request for themselves', function () {
    $this->actingAs($this->wargaUser);

    $this->post(route('portal.surat.store'), [
        'jenis_surat' => 'Surat Keterangan Domisili',
        'keperluan' => 'Pembukaan rekening bank',
    ])->assertRedirect(route('portal.surat'));

    $warga = Warga::find($this->wargaUser->warga->id);

    expect(Surat::where('warga_id', $warga->id)
        ->where('keperluan', 'Pembukaan rekening bank')
        ->exists())->toBeTrue();
});

it('asks a warga without a warga record to complete their data', function () {
    $user = User::create([
        'name' => 'Akun Lama',
        'email' => 'lama@example.com',
        'password' => 'password123',
        'role' => 'warga',
    ]);

    $this->actingAs($user)
        ->get(route('portal.index'))
        ->assertRedirect(route('portal.lengkapi'));

    $this->get(route('portal.lengkapi'))->assertOk();

    $this->post(route('portal.lengkapi.store'), [
        'nik' => '3275018888888888',
        'nama_lengkap' => 'Akun Lama',
        'jenis_kelamin' => 'Laki-laki',
        'status_domisili' => 'Tetap',
        'no_telp' => '081200000001',
    ])->assertRedirect(route('portal.index'));

    expect($user->fresh()->warga)->not->toBeNull();
    $this->get(route('portal.index'))->assertOk();
});

it('forbids a warga from viewing another warga surat', function () {
    $this->actingAs($this->wargaUser);

    $otherSurat = Surat::where('warga_id', '!=', $this->wargaUser->warga->id)->firstOrFail();

    $this->get(route('portal.surat.show', $otherSurat))->assertForbidden();
});

it('lets a warga update their own profile', function () {
    $this->actingAs($this->wargaUser);

    $this->put(route('portal.profil.update'), [
        'name' => 'Budi Santoso Baru',
        'no_telp' => '081200000000',
        'pekerjaan' => 'Wiraswasta',
        'alamat' => 'Jl. Sukamaju No. 12',
    ])->assertRedirect(route('portal.profil'));

    expect($this->wargaUser->fresh()->name)->toBe('Budi Santoso Baru');
    expect($this->wargaUser->warga->fresh()->no_telp)->toBe('081200000000');
});
