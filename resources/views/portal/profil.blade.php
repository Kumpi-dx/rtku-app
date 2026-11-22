@extends('layouts.portal')

@section('title', 'Profil Saya - Portal Warga SiRT-RW')

@section('content')
  <h5 class="font-heading fw-bold mb-1">Profil Saya</h5>
  <p class="text-muted mb-3" style="font-size: 0.85rem;">Perbarui data kontak Anda agar pengurus mudah menghubungi.</p>

  <div class="card-custom p-3 mb-3">
    <div class="d-flex align-items-center gap-3">
      <div class="bg-soft-green text-primary-green rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; font-size: 1.6rem;">
        <i class="bi bi-person"></i>
      </div>
      <div>
        <div class="fw-bold font-heading">{{ $warga->nama_lengkap }}</div>
        <small class="text-muted">NIK {{ $warga->nik }}</small>
        <div class="mt-1">
          <span class="badge badge-soft-info">{{ $warga->status_domisili }}</span>
          <span class="badge badge-soft-secondary">{{ $warga->status_perkawinan ?? 'Belum Kawin' }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="card-custom p-3">
    <form action="{{ route('portal.profil.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label small fw-semibold">Nama Lengkap</label>
          <input type="text" name="name" value="{{ old('name', $warga->nama_lengkap) }}" class="form-control" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">No. Telepon / WA</label>
          <input type="text" name="no_telp" value="{{ old('no_telp', $warga->no_telp) }}" class="form-control" placeholder="0812...">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Pekerjaan</label>
          <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}" class="form-control" placeholder="Pekerjaan">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Alamat</label>
          <textarea name="alamat" rows="2" class="form-control" placeholder="Alamat lengkap">{{ old('alamat', $warga->alamat) }}</textarea>
        </div>
      </div>

      <hr class="my-4" style="border-color: var(--border-color);">

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Kata Sandi Baru (opsional)</label>
          <input type="password" name="password" class="form-control" minlength="8" placeholder="Kosongkan bila tidak diubah">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Konfirmasi Kata Sandi</label>
          <input type="password" name="password_confirmation" class="form-control" minlength="8">
        </div>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary-green">Simpan Perubahan</button>
      </div>
    </form>
  </div>
@endsection
