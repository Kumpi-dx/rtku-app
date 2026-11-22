@extends('layouts.app')

@section('title', 'Edit Warga - Sistem Informasi Manajemen RT/RW')
@section('page', 'warga')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Edit Data Warga</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Perbarui data warga RT 005 / RW 012 Sukamaju.</p>
    </div>
    <a href="{{ route('warga.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3" style="max-width: 900px;">
    <form action="{{ route('warga.update', $warga) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">NIK (16 Digit)</label>
          <input type="text" name="nik" value="{{ old('nik', $warga->nik) }}" class="form-control form-control-sm" required maxlength="16" pattern="[0-9]{16}">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-select form-select-sm" required>
            <option value="Laki-laki" @selected(old('jenis_kelamin', $warga->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin', $warga->jenis_kelamin) === 'Perempuan')>Perempuan</option>
          </select>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">No. Telepon / WA</label>
          <input type="text" name="no_telp" value="{{ old('no_telp', $warga->no_telp) }}" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Pekerjaan</label>
          <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Status Domisili</label>
          <select name="status_domisili" class="form-select form-select-sm" required>
            <option value="Tetap" @selected(old('status_domisili', $warga->status_domisili) === 'Tetap')>Tetap</option>
            <option value="Kontrak" @selected(old('status_domisili', $warga->status_domisili) === 'Kontrak')>Kontrak</option>
            <option value="Pindah" @selected(old('status_domisili', $warga->status_domisili) === 'Pindah')>Pindah</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Alamat</label>
          <textarea name="alamat" class="form-control form-control-sm" rows="2">{{ old('alamat', $warga->alamat) }}</textarea>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Status Perkawinan</label>
          <select name="status_perkawinan" class="form-select form-select-sm">
            <option value="">Belum Kawin</option>
            <option value="Belum Kawin" @selected(old('status_perkawinan', $warga->status_perkawinan) === 'Belum Kawin')>Belum Kawin</option>
            <option value="Kawin" @selected(old('status_perkawinan', $warga->status_perkawinan) === 'Kawin')>Kawin</option>
            <option value="Cerai Hidup" @selected(old('status_perkawinan', $warga->status_perkawinan) === 'Cerai Hidup')>Cerai Hidup</option>
            <option value="Cerai Mati" @selected(old('status_perkawinan', $warga->status_perkawinan) === 'Cerai Mati')>Cerai Mati</option>
          </select>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('warga.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Perubahan</button>
      </div>
    </form>
  </div>
@endsection
