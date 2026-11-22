@extends('layouts.portal')

@section('title', 'Agenda Kegiatan - Portal Warga SiRT-RW')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h5 class="font-heading fw-bold mb-1">Agenda Kegiatan</h5>
      <p class="text-muted mb-0" style="font-size: 0.85rem;">Kegiatan warga yang akan datang.</p>
    </div>
    <a href="{{ route('portal.pengumuman') }}" class="btn btn-sm btn-light"><i class="bi bi-megaphone"></i>Info</a>
  </div>

  @forelse ($agendas as $item)
    <a href="{{ route('portal.pengumuman.show', $item) }}" class="portal-list-item">
      <div class="portal-date-badge">
        <div style="font-size: 0.65rem; text-transform: uppercase;">{{ $item->tanggal_mulai->locale('id')->translatedFormat('M') }}</div>
        <div style="font-size: 1.1rem; line-height: 1;">{{ $item->tanggal_mulai->format('d') }}</div>
      </div>
      <div class="flex-grow-1">
        <div class="fw-semibold" style="font-size: 0.9rem;">{{ $item->judul }}</div>
        <small class="text-muted">
          <i class="bi bi-clock me-1"></i>{{ $item->waktu_mulai ?? '--:--' }}{{ $item->waktu_selesai ? ' - ' . $item->waktu_selesai : '' }}
          @if ($item->lokasi)
            <i class="bi bi-geo-alt ms-2 me-1"></i>{{ $item->lokasi }}
          @endif
        </small>
      </div>
      <i class="bi bi-chevron-right text-muted"></i>
    </a>
  @empty
    <div class="card-custom p-4 text-center text-muted" style="font-size: 0.85rem;">Belum ada agenda mendatang.</div>
  @endforelse
@endsection
