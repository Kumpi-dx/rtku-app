@extends('layouts.portal')

@section('title', 'Lengkapi Data Warga - Portal Warga SiRT-RW')

@section('content')
  <h5 class="font-heading fw-bold mb-1">Lengkapi Data Warga</h5>
  <p class="text-muted mb-3" style="font-size: 0.85rem;">Akun Anda belum memiliki data kependudukan. Isi data berikut agar pengurus dapat memverifikasi Anda.</p>

  <div class="alert alert-light border" style="font-size: 0.83rem;">
    <i class="bi bi-info-circle me-1 text-primary-green"></i>
    Data yang Anda isi akan digunakan untuk keperluan administrasi RT 005 / RW 012.
  </div>

  <div class="card-custom p-3">
    <form action="{{ route('portal.lengkapi.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label small fw-semibold">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->name) }}" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">NIK</label>
          <input type="text" name="nik" value="{{ old('nik') }}" class="form-control" inputmode="numeric" pattern="[0-9]{16}" maxlength="16" placeholder="16 digit NIK" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-select" required>
            <option value="">Pilih</option>
            <option value="Laki-laki" @selected(old('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin') === 'Perempuan')>Perempuan</option>
          </select>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">No. Telepon / WA</label>
          <input type="text" name="no_telp" value="{{ old('no_telp') }}" class="form-control" placeholder="08xxxxxxxxxx">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Status Domisili</label>
          <select name="status_domisili" class="form-select" required>
            @foreach (['Tetap', 'Kontrak', 'Pindah'] as $status)
              <option value="{{ $status }}" @selected(old('status_domisili', 'Tetap') === $status)>{{ $status }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Status Perkawinan</label>
          <select name="status_perkawinan" class="form-select">
            <option value="">Pilih</option>
            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
              <option value="{{ $status }}" @selected(old('status_perkawinan') === $status)>{{ $status }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Pekerjaan</label>
          <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="form-control" placeholder="Pekerjaan">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Alamat</label>
          <textarea name="alamat" rows="2" class="form-control" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
        </div>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary-green">Simpan & Lanjutkan</button>
      </div>
    </form>
  </div>
@endsection
