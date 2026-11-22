@extends('layouts.portal')

@section('title', 'Pengumuman - Portal Warga SiRT-RW')

@php
  $kategoriBadge = ['Kerja Bakti' => 'success', 'Keamanan' => 'info', 'Rapat' => 'warning', 'Lainnya' => 'secondary'];
@endphp

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h5 class="font-heading fw-bold mb-1">Pengumuman</h5>
      <p class="text-muted mb-0" style="font-size: 0.85rem;">Informasi terbaru untuk warga RT 005.</p>
    </div>
    <a href="{{ route('portal.agenda') }}" class="btn btn-sm btn-light"><i class="bi bi-calendar-event"></i>Agenda</a>
  </div>

  @forelse ($pengumumans as $item)
    <a href="{{ route('portal.pengumuman.show', $item) }}" class="portal-list-item">
      <div class="tile-icon"><i class="bi bi-megaphone"></i></div>
      <div class="flex-grow-1">
        <div class="fw-semibold" style="font-size: 0.9rem;">{{ $item->judul }}</div>
        <small class="text-muted">
          <span class="badge badge-soft-{{ $kategoriBadge[$item->kategori] ?? 'secondary' }} me-1">{{ $item->kategori }}</span>
          {{ $item->tanggal_mulai?->format('d M Y') ?? '' }}
        </small>
      </div>
      <i class="bi bi-chevron-right text-muted"></i>
    </a>
  @empty
    <div class="card-custom p-4 text-center text-muted" style="font-size: 0.85rem;">Belum ada pengumuman.</div>
  @endforelse

  @if ($pengumumans->hasPages())
    <div class="mt-3">{{ $pengumumans->links() }}</div>
  @endif
@endsection
