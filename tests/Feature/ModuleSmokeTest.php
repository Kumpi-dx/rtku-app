<?php

use App\Models\Iuran;
use App\Models\KategoriKeuangan;
use App\Models\Keuangan;
use App\Models\Pengumuman;
use App\Models\Surat;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->actingAs(User::query()->firstOrFail());
});

it('renders the dashboard with statistics', function () {
    $this->get(route('dashboard'))->assertOk();
});

it('renders warga pages', function () {
    $warga = Warga::query()->firstOrFail();

    $this->get(route('warga.index'))->assertOk();
    $this->get(route('warga.create'))->assertOk();
    $this->get(route('warga.show', $warga))->assertOk();
    $this->get(route('warga.edit', $warga))->assertOk();
});

it('renders surat pages', function () {
    $surat = Surat::query()->firstOrFail();

    $this->get(route('surat.index'))->assertOk();
    $this->get(route('surat.create'))->assertOk();
    $this->get(route('surat.show', $surat))->assertOk();
    $this->get(route('surat.edit', $surat))->assertOk();
});

it('renders keuangan pages', function () {
    $keuangan = Keuangan::query()->firstOrFail();
    $kategori = KategoriKeuangan::query()->firstOrFail();

    $this->get(route('keuangan.index'))->assertOk();
    $this->get(route('keuangan.create'))->assertOk();
    $this->get(route('keuangan.edit', $keuangan))->assertOk();

    $this->get(route('kategori-keuangan.index'))->assertOk();
    $this->get(route('kategori-keuangan.create'))->assertOk();
    $this->get(route('kategori-keuangan.edit', $kategori))->assertOk();
});

it('shows the current month iuran status for every warga on the dashboard', function () {
    $periode = now()->format('Y-m');

    $belumLunas = Warga::query()
        ->whereDoesntHave('iurans', fn ($query) => $query->where('periode', $periode)->where('status', 'Lunas'))
        ->first();

    expect($belumLunas)->not->toBeNull();

    $response = $this->get(route('dashboard'))->assertOk();

    $response->assertSee('Status Iuran Warga');
    $response->assertSee('data-iuran-row', false);
    $response->assertSee($belumLunas->nama_lengkap);
    $response->assertSee('Belum Lunas');
});

it('marks a warga iuran as lunas from the dashboard', function () {
    $warga = Warga::query()->firstOrFail();
    $periode = now()->format('Y-m');

    Iuran::where('warga_id', $warga->id)->where('periode', $periode)->delete();

    $this->post(route('iuran.lunas', $warga), ['periode' => $periode])
        ->assertRedirect();

    $iuran = Iuran::where('warga_id', $warga->id)->where('periode', $periode)->first();

    expect($iuran)->not->toBeNull();
    expect($iuran->status)->toBe('Lunas');
    expect($iuran->tanggal_bayar)->not->toBeNull();
});

it('renders iuran pages', function () {
    $iuran = Iuran::query()->firstOrFail();

    $this->get(route('iuran.index'))->assertOk();
    $this->get(route('iuran.create'))->assertOk();
    $this->get(route('iuran.edit', $iuran))->assertOk();
});

it('renders pengumuman pages', function () {
    $pengumuman = Pengumuman::query()->firstOrFail();

    $this->get(route('pengumuman.index'))->assertOk();
    $this->get(route('pengumuman.create'))->assertOk();
    $this->get(route('pengumuman.show', $pengumuman))->assertOk();
    $this->get(route('pengumuman.edit', $pengumuman))->assertOk();
});

it('renders pengguna pages', function () {
    $pengguna = User::query()->firstOrFail();

    $this->get(route('pengguna.index'))->assertOk();
    $this->get(route('pengguna.create'))->assertOk();
    $this->get(route('pengguna.edit', $pengguna))->assertOk();
});

it('creates a warga record', function () {
    $this->post(route('warga.store'), [
        'nik' => '3275010101010001',
        'nama_lengkap' => 'Warga Baru',
        'jenis_kelamin' => 'Laki-laki',
        'status_domisili' => 'Tetap',
    ])->assertRedirect(route('warga.index'));

    expect(Warga::where('nik', '3275010101010001')->exists())->toBeTrue();
});

it('updates a surat status', function () {
    $surat = Surat::query()->firstOrFail();

    $this->patch(route('surat.status', $surat), ['status' => 'Disetujui'])
        ->assertRedirect(route('surat.show', $surat));

    expect($surat->fresh()->status)->toBe('Disetujui');
});

it('records a keuangan transaction', function () {
    $kategori = KategoriKeuangan::query()->firstOrFail();

    $this->post(route('keuangan.store'), [
        'tanggal' => now()->toDateString(),
        'kategori_keuangan_id' => $kategori->id,
        'keterangan' => 'Transaksi uji',
        'nominal' => 150000,
        'tipe' => $kategori->tipe,
    ])->assertRedirect(route('keuangan.index'));

    expect(Keuangan::where('keterangan', 'Transaksi uji')->exists())->toBeTrue();
});

it('creates pengurus accounts from the pengguna module', function () {
    $this->post(route('pengguna.store'), [
        'name' => 'Pengurus Baru',
        'email' => 'pengurusbaru@rtku.id',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertRedirect(route('pengguna.index'));

    expect(User::where('email', 'pengurusbaru@rtku.id')->value('role'))->toBe('pengurus');
});

it('lists warga accounts that have not completed their data', function () {
    User::factory()->create([
        'name' => 'Warga Belum Lengkap',
        'email' => 'belum-lengkap@rtku.id',
        'password' => 'password',
        'role' => 'warga',
    ]);

    $this->get(route('warga.index'))
        ->assertOk()
        ->assertSee('Warga Belum Melengkapi Data')
        ->assertSee('belum-lengkap@rtku.id')
        ->assertSee('Belum Melengkapi NIK');
});

it('does not delete the currently authenticated user', function () {
    $user = User::query()->firstOrFail();

    $this->delete(route('pengguna.destroy', $user))
        ->assertRedirect(route('pengguna.index'));

    expect(User::find($user->id))->not->toBeNull();
});
