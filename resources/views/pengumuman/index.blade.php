@extends('layouts.app')

@section('title', 'Pengumuman & Kegiatan - Sistem Informasi Manajemen RT/RW')
@section('page', 'pengumuman')

@php
  $kategoriBadge = ['Kerja Bakti' => 'success', 'Keamanan' => 'info', 'Rapat' => 'warning', 'Lainnya' => 'secondary'];
@endphp

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Pengumuman & Agenda Lingkungan</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Pusat informasi kegiatan warga RT 005 / RW 012.</p>
    </div>
    <a href="{{ route('pengumuman.create') }}" class="btn btn-sm btn-primary-green">
      <i class="bi bi-plus-lg"></i>Buat Pengumuman
    </a>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.875rem;">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-3">
    @forelse ($pengumumans as $pengumuman)
      <div class="col-12 col-md-6">
        <div class="card-custom p-3 h-100 d-flex flex-column">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <span class="badge badge-soft-{{ $kategoriBadge[$pengumuman->kategori] ?? 'secondary' }}">{{ $pengumuman->kategori }}</span>
            @unless ($pengumuman->is_publik)
              <span class="badge badge-soft-secondary">Privat</span>
            @endunless
          </div>
          <h5 class="font-heading fw-bold mb-2">{{ $pengumuman->judul }}</h5>
          <p class="text-muted" style="font-size: 0.875rem;">{{ \Illuminate\Support\Str::limit($pengumuman->isi, 160) }}</p>
          <small class="text-muted mt-auto d-block mb-3">
            <i class="bi bi-calendar3 me-1"></i>
            {{ $pengumuman->tanggal_mulai ? $pengumuman->tanggal_mulai->format('d M Y') : 'Tanpa tanggal' }}
            @if ($pengumuman->waktu_mulai)
              &middot; {{ $pengumuman->waktu_mulai }}{{ $pengumuman->waktu_selesai ? ' - ' . $pengumuman->waktu_selesai : '' }}
            @endif
            @if ($pengumuman->lokasi)
              &middot; {{ $pengumuman->lokasi }}
            @endif
          </small>
          <div class="d-flex gap-2">
            <a href="{{ route('pengumuman.show', $pengumuman) }}" class="btn btn-xs btn-light"><i class="bi bi-eye"></i>Detail</a>
            <a href="{{ route('pengumuman.edit', $pengumuman) }}" class="btn btn-xs btn-light"><i class="bi bi-pencil"></i>Edit</a>
            <form action="{{ route('pengumuman.destroy', $pengumuman) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengumuman ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-xs btn-light text-danger"><i class="bi bi-trash"></i>Hapus</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="card-custom p-4 text-center text-muted">Belum ada pengumuman.</div>
      </div>
    @endforelse
  </div>

  @if ($pengumumans->hasPages())
    <div class="mt-3">{{ $pengumumans->links() }}</div>
  @endif
@endsection
