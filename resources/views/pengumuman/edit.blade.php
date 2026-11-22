@extends('layouts.app')

@section('title', 'Edit Pengumuman - Sistem Informasi Manajemen RT/RW')
@section('page', 'pengumuman')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Edit Pengumuman & Kegiatan</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Perbarui pengumuman atau kegiatan lingkungan RT 005 / RW 012.</p>
    </div>
    <a href="{{ route('pengumuman.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3" style="max-width: 900px;">
    <form action="{{ route('pengumuman.update', $pengumuman) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="section-title text-muted">
        <i class="bi bi-megaphone text-primary-green"></i>
        <span>Pengumuman</span>
      </div>

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label small fw-semibold">Judul</label>
          <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small fw-semibold">Kategori</label>
          <select name="kategori" class="form-select form-select-sm" required>
            <option value="Kerja Bakti" @selected(old('kategori', $pengumuman->kategori) === 'Kerja Bakti')>Kerja Bakti</option>
            <option value="Keamanan" @selected(old('kategori', $pengumuman->kategori) === 'Keamanan')>Keamanan</option>
            <option value="Rapat" @selected(old('kategori', $pengumuman->kategori) === 'Rapat')>Rapat</option>
            <option value="Lainnya" @selected(old('kategori', $pengumuman->kategori) === 'Lainnya')>Lainnya</option>
          </select>
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small fw-semibold">Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai?->toDateString()) }}" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small fw-semibold">Waktu Mulai</label>
          <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $pengumuman->waktu_mulai) }}" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small fw-semibold">Waktu Selesai</label>
          <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $pengumuman->waktu_selesai) }}" class="form-control form-control-sm">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Lokasi</label>
          <input type="text" name="lokasi" value="{{ old('lokasi', $pengumuman->lokasi) }}" class="form-control form-control-sm">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Isi / Isi Pengumuman</label>
          <textarea name="isi" class="form-control form-control-sm" rows="5">{{ old('isi', $pengumuman->isi) }}</textarea>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_publik" value="1" id="isPublik" @checked(old('is_publik', $pengumuman->is_publik))>
            <label class="form-check-label" for="isPublik" style="font-size: 0.9rem;">Publikasikan pengumuman ini</label>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('pengumuman.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Perubahan</button>
      </div>
    </form>
  </div>
@endsection
