@extends('layouts.app')

@section('title', 'Tambah Pengguna - Sistem Informasi Manajemen RT/RW')
@section('page', 'pengguna')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Tambah Pengguna</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Buat akun pengguna pengurus RT baru.</p>
    </div>
    <a href="{{ route('pengguna.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i>Kembali</a>
  </div>

  <div class="card-custom p-3" style="max-width: 700px;">
    <form action="{{ route('pengguna.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label small fw-semibold">Nama</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Kata Sandi</label>
          <input type="password" name="password" class="form-control form-control-sm" required minlength="8">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Konfirmasi Kata Sandi</label>
          <input type="password" name="password_confirmation" class="form-control form-control-sm" required minlength="8">
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('pengguna.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Pengguna</button>
      </div>
    </form>
  </div>
@endsection
