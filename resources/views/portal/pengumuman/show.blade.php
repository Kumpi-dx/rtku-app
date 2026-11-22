@extends('layouts.portal')

@section('title', 'Detail Pengumuman - Portal Warga SiRT-RW')

@php
  $kategoriBadge = ['Kerja Bakti' => 'success', 'Keamanan' => 'info', 'Rapat' => 'warning', 'Lainnya' => 'secondary'];
@endphp

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <a href="{{ route('portal.pengumuman') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i>Kembali</a>
  </div>

  <div class="card-custom p-3">
    <span class="badge badge-soft-{{ $kategoriBadge[$pengumuman->kategori] ?? 'secondary' }} mb-2">{{ $pengumuman->kategori }}</span>
    <h5 class="font-heading fw-bold mb-2">{{ $pengumuman->judul }}</h5>
    <p class="text-muted" style="font-size: 0.9rem;">{{ $pengumuman->isi }}</p>

    <div class="row g-3 mt-3" style="font-size: 0.85rem;">
      <div class="col-6">
        <small class="text-muted d-block">Tanggal</small>
        <span class="fw-semibold">{{ $pengumuman->tanggal_mulai?->format('d M Y') ?? '-' }}</span>
      </div>
      <div class="col-6">
        <small class="text-muted d-block">Waktu</small>
        <span class="fw-semibold">{{ $pengumuman->waktu_mulai ?? '-' }}{{ $pengumuman->waktu_selesai ? ' - ' . $pengumuman->waktu_selesai : '' }}</span>
      </div>
      <div class="col-12">
        <small class="text-muted d-block">Lokasi</small>
        <span class="fw-semibold">{{ $pengumuman->lokasi ?? '-' }}</span>
      </div>
    </div>
  </div>
@endsection
