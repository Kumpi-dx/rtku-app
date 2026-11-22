<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\KategoriKeuanganController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check() && auth()->user()->isWarga()) {
        return redirect()->route('portal.index');
    }

    return redirect()->route('dashboard');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'pengurus.only'])
    ->name('dashboard');

Route::middleware(['auth', 'pengurus.only'])->group(function () {
    Route::get('warga/export', [WargaController::class, 'export'])->name('warga.export');
    Route::resource('warga', WargaController::class);
    Route::patch('surat/{surat}/status', [SuratController::class, 'updateStatus'])->name('surat.status');
    Route::resource('surat', SuratController::class);
    Route::resource('keuangan', KeuanganController::class)->except(['show']);
    Route::resource('kategori-keuangan', KategoriKeuanganController::class)
        ->parameters(['kategori-keuangan' => 'kategoriKeuangan'])
        ->except(['show']);
    Route::post('iuran/{warga}/lunas', [IuranController::class, 'markLunas'])->name('iuran.lunas');
    Route::resource('iuran', IuranController::class)->except(['show']);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('pengguna', PenggunaController::class)
        ->parameters(['pengguna' => 'pengguna'])
        ->except(['show']);
});

Route::middleware(['auth', 'warga.only'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('lengkapi-data', [PortalController::class, 'lengkapi'])->name('lengkapi');
    Route::post('lengkapi-data', [PortalController::class, 'simpanLengkapi'])->name('lengkapi.store');
    Route::get('/', [PortalController::class, 'index'])->name('index');
    Route::get('profil', [PortalController::class, 'profil'])->name('profil');
    Route::put('profil', [PortalController::class, 'updateProfil'])->name('profil.update');
    Route::get('iuran', [PortalController::class, 'iuran'])->name('iuran');
    Route::get('surat', [PortalController::class, 'surat'])->name('surat');
    Route::get('surat/baru', [PortalController::class, 'suratCreate'])->name('surat.create');
    Route::post('surat', [PortalController::class, 'suratStore'])->name('surat.store');
    Route::get('surat/{surat}', [PortalController::class, 'suratShow'])->name('surat.show');
    Route::get('pengumuman', [PortalController::class, 'pengumuman'])->name('pengumuman');
    Route::get('pengumuman/{pengumuman}', [PortalController::class, 'pengumumanShow'])->name('pengumuman.show');
    Route::get('agenda', [PortalController::class, 'agenda'])->name('agenda');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
