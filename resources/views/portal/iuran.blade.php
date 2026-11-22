@extends('layouts.portal')

@section('title', 'Iuran Saya - Portal Warga SiRT-RW')

@php
  $badgeMap = ['Belum Lunas' => 'danger', 'Lunas' => 'success', 'Sebagian' => 'warning'];
@endphp

@section('content')
  <h5 class="font-heading fw-bold mb-1">Iuran Saya</h5>
  <p class="text-muted mb-3" style="font-size: 0.85rem;">Riwayat pembayaran iuran kas Anda.</p>

  <div class="row g-2 mb-3">
    <div class="col-6">
      <div class="card-custom p-3 h-100">
        <small class="text-muted d-block mb-1">Sudah Dibayar</small>
        <div class="fw-bold text-success" style="font-size: 1.05rem;">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
      </div>
    </div>
    <div class="col-6">
      <div class="card-custom p-3 h-100">
        <small class="text-muted d-block mb-1">Tunggakan</small>
        <div class="fw-bold text-danger" style="font-size: 1.05rem;">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</div>
      </div>
    </div>
  </div>

  @forelse ($iurans as $iuran)
    <div class="portal-list-item">
      <div class="portal-date-badge" style="min-width: 62px;">
        <div style="font-size: 0.65rem; text-transform: uppercase;">{{ \Illuminate\Support\Carbon::createFromFormat('Y-m', $iuran->periode)->locale('id')->translatedFormat('M') }}</div>
        <div style="font-size: 0.95rem; line-height: 1;">{{ \Illuminate\Support\Carbon::createFromFormat('Y-m', $iuran->periode)->format('Y') }}</div>
      </div>
      <div class="flex-grow-1">
        <div class="fw-semibold" style="font-size: 0.9rem;">Iuran {{ \Illuminate\Support\Carbon::createFromFormat('Y-m', $iuran->periode)->locale('id')->translatedFormat('F Y') }}</div>
        <small class="text-muted">
          Rp {{ number_format($iuran->jumlah, 0, ',', '.') }}
          @if ($iuran->tanggal_bayar)
            - dibayar {{ $iuran->tanggal_bayar->format('d M Y') }}
          @endif
        </small>
      </div>
      <span class="badge badge-soft-{{ $badgeMap[$iuran->status] ?? 'secondary' }}">{{ $iuran->status }}</span>
    </div>
  @empty
    <div class="card-custom p-4 text-center text-muted" style="font-size: 0.85rem;">Belum ada data iuran untuk Anda.</div>
  @endforelse

  @if ($iurans->hasPages())
    <div class="mt-3">{{ $iurans->links() }}</div>
  @endif

  <div class="alert alert-info mt-3" style="font-size: 0.8rem;">
    <i class="bi bi-info-circle me-1"></i>Bila ada pembayaran yang belum tercatat, silakan hubungi Bendahara RT.
  </div>
@endsection
