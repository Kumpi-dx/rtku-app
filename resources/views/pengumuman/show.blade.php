@extends('layouts.app')

@section('title', 'Detail Pengumuman - Sistem Informasi Manajemen RT/RW')
@section('page', 'pengumuman')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Detail Pengumuman & Kegiatan</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Informasi publik kegiatan warga RT 005 / RW 012 Sukamaju.</p>
    </div>
    <a href="{{ route('pengumuman.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3">
    <div class="d-flex align-items-center gap-2 mb-2">
      <span class="badge badge-soft-success mb-2">{{ $pengumuman->kategori }}</span>
      <h5 class="font-heading fw-bold mb-0">{{ $pengumuman->judul }}</h5>
    </div>
    <p class="text-muted" style="font-size: 0.9rem;">{{ $pengumuman->isi }}</p>
    <div class="row g-3 mt-3">
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Tanggal Mulai</small>
        <div class="fw-semibold">{{ $pengumuman->tanggal_mulai ? $pengumuman->tanggal_mulai->format('d M Y') : '-' }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Waktu Mulai</small>
        <div class="fw-semibold">{{ $pengumuman->waktu_mulai ?? '-' }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Waktu Selesai</small>
        <div class="fw-semibold">{{ $pengumuman->waktu_selesai ?? '-' }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Lokasi</small>
        <div class="fw-semibold">{{ $pengumuman->lokasi ?? '-' }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Status Publikasi</small>
        <div class="fw-semibold">{{ $pengumuman->is_publik ? 'Publik' : 'Privat' }}</div>
      </div>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-3">
      <a href="{{ route('pengumuman.edit', $pengumuman) }}" class="btn btn-sm btn-outline-success">
        <i class="bi bi-pencil"></i>Edit Pengumuman
      </a>
      <form action="{{ route('pengumuman.destroy', $pengumuman) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
          <i class="bi bi-trash"></i>Hapus Pengumuman
        </button>
      </form>
    </div>
  </div>
@endsection
