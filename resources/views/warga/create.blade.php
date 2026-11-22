@extends('layouts.app')

@section('title', 'Tambah Warga - Sistem Informasi Manajemen RT/RW')
@section('page', 'warga')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Tambah Data Warga Baru</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Catat data penduduk warga RT 005 / RW 012 Sukamaju.</p>
    </div>
    <a href="{{ route('warga.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3" style="max-width: 900px;">
    <form action="{{ route('warga.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">NIK (16 Digit)</label>
          <input type="text" name="nik" class="form-control form-control-sm" required placeholder="3275..." maxlength="16" pattern="[0-9]{16}">
          <div class="form-text" style="font-size: 0.75rem;">Wajib 16 digit angka sesuai identitas KTP.</div>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-control form-control-sm" required placeholder="Sesuai KTP">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-select form-select-sm" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">No. Telepon / WA</label>
          <input type="text" name="no_telp" class="form-control form-control-sm" placeholder="0812...">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Pekerjaan</label>
          <input type="text" name="pekerjaan" class="form-control form-control-sm" placeholder="Pekerjaan">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Status Domisili</label>
          <select name="status_domisili" class="form-select form-select-sm" required>
            <option value="Tetap">Tetap</option>
            <option value="Kontrak">Kontrak</option>
            <option value="Pindah">Pindah</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Alamat</label>
          <textarea name="alamat" class="form-control form-control-sm" rows="2" placeholder="Jl. Sukamaju No. ..."></textarea>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Status Perkawinan</label>
          <select name="status_perkawinan" class="form-select form-select-sm">
            <option value="">Belum Kawin</option>
            <option value="Belum Kawin">Belum Kawin</option>
            <option value="Kawin">Kawin</option>
            <option value="Cerai Hidup">Cerai Hidup</option>
            <option value="Cerai Mati">Cerai Mati</option>
          </select>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('warga.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Data</button>
      </div>
    </form>
  </div>
@endsection
