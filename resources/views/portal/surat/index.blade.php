@extends('layouts.portal')

@section('title', 'Surat Saya - Portal Warga SiRT-RW')

@php
  $badgeMap = ['Pending' => 'warning', 'Diproses' => 'info', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
@endphp

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h5 class="font-heading fw-bold mb-1">Surat Saya</h5>
      <p class="text-muted mb-0" style="font-size: 0.85rem;">Ajukan dan pantau status surat Anda.</p>
    </div>
    <a href="{{ route('portal.surat.create') }}" class="btn btn-sm btn-primary-green"><i class="bi bi-plus-lg"></i>Ajukan</a>
  </div>

  @forelse ($surats as $surat)
    <a href="{{ route('portal.surat.show', $surat) }}" class="portal-list-item">
      <div class="tile-icon"><i class="bi bi-file-earmark-text"></i></div>
      <div class="flex-grow-1">
        <div class="fw-semibold" style="font-size: 0.9rem;">{{ $surat->jenis_surat }}</div>
        <small class="text-muted">{{ $surat->no_surat }} - {{ $surat->tanggal_pengajuan?->format('d M Y') }}</small>
      </div>
      <span class="badge badge-soft-{{ $badgeMap[$surat->status] ?? 'info' }}">{{ $surat->status }}</span>
    </a>
  @empty
    <div class="card-custom p-4 text-center">
      <i class="bi bi-file-earmark-text display-6 text-muted d-block mb-2"></i>
      <p class="text-muted mb-3" style="font-size: 0.85rem;">Anda belum pernah mengajukan surat.</p>
      <a href="{{ route('portal.surat.create') }}" class="btn btn-primary-green">Ajukan Surat Pertama</a>
    </div>
  @endforelse

  @if ($surats->hasPages())
    <div class="mt-3">{{ $surats->links() }}</div>
  @endif
@endsection
