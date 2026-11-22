@extends('layouts.app')

@section('title', 'Buat Pengumuman - Sistem Informasi Manajemen RT/RW')
@section('page', 'pengumuman')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Buat Pengumuman & Kegiatan</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Publikasikan pengumuman atau kegiatan lingkungan RT 005 / RW 012.</p>
    </div>
    <a href="{{ route('pengumuman.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3" style="max-width: 900px;">
    <form action="{{ route('pengumuman.store') }}" method="POST">
      @csrf

      <div class="section-title text-muted">
        <i class="bi bi-megaphone text-primary-green"></i>
        <span>Pengumuman</span>
      </div>

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label small fw-semibold">Judul</label>
          <input type="text" name="judul" class="form-control form-control-sm" required placeholder="Judul pengumuman / kegiatan">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small fw-semibold">Kategori</label>
          <select name="kategori" class="form-select form-select-sm" required>
            <option value="Kerja Bakti">Kerja Bakti</option>
            <option value="Keamanan">Keamanan</option>
            <option value="Rapat">Rapat</option>
            <option value="Lainnya">Lainnya</option>
          </select>
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small fw-semibold">Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small fw-semibold">Waktu Mulai</label>
          <input type="time" name="waktu_mulai" class="form-control form-control-sm">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small fw-semibold">Waktu Selesai</label>
          <input type="time" name="waktu_selesai" class="form-control form-control-sm">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Lokasi</label>
          <input type="text" name="lokasi" class="form-control form-control-sm" placeholder="Lokasi kegiatan">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Isi / Isi Pengumuman</label>
          <textarea name="isi" class="form-control form-control-sm" rows="5" required placeholder="Isi pengumuman / kegiatan"></textarea>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_publik" value="1" id="isPublik">
            <label class="form-check-label" for="isPublik" style="font-size: 0.9rem;">Publikasikan pengumuman ini</label>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('pengumuman.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Pengumuman</button>
      </div>
    </form>
  </div>
@endsection
