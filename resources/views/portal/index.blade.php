@extends('layouts.portal')

@section('title', 'Beranda - Portal Warga SiRT-RW')

@php
  $badgeMap = ['Pending' => 'warning', 'Diproses' => 'info', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
  $iuranStatus = $iuranBulanIni->status ?? 'Belum Lunas';
  $iuranBadge = $iuranStatus === 'Lunas' ? 'success' : ($iuranStatus === 'Sebagian' ? 'warning' : 'danger');
@endphp

@section('content')
  <div class="portal-hero mb-3">
    <div class="d-flex justify-content-between align-items-start gap-2">
      <div>
        <small class="d-block">Selamat datang,</small>
        <h5 class="font-heading fw-bold mb-1">{{ $warga->nama_lengkap }}</h5>
        <small>NIK {{ $warga->nik }}</small>
      </div>
      <i class="bi bi-house-heart" style="font-size: 2.2rem; opacity: 0.85;"></i>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.25);">
      <div>
        <small class="d-block">Iuran bulan ini ({{ now()->locale('id')->translatedFormat('F Y') }})</small>
        <span class="badge bg-light text-dark mt-1">{{ $iuranStatus }}</span>
      </div>
      <div class="text-end">
        <small class="d-block">Total tunggakan</small>
        <strong>Rp {{ number_format($tunggakan, 0, ',', '.') }}</strong>
      </div>
    </div>
  </div>

  <div class="portal-grid mb-2">
    <a href="{{ route('portal.iuran') }}" class="portal-tile">
      <div class="tile-icon"><i class="bi bi-wallet2"></i></div>
      <div>
        <div class="tile-title">Iuran Saya</div>
        <div class="tile-sub">Riwayat & status</div>
      </div>
    </a>
    <a href="{{ route('portal.surat.create') }}" class="portal-tile">
      <div class="tile-icon"><i class="bi bi-file-earmark-plus"></i></div>
      <div>
        <div class="tile-title">Ajukan Surat</div>
        <div class="tile-sub">Minta surat RT</div>
      </div>
    </a>
    <a href="{{ route('portal.pengumuman') }}" class="portal-tile">
      <div class="tile-icon"><i class="bi bi-megaphone-fill"></i></div>
      <div>
        <div class="tile-title">Pengumuman</div>
        <div class="tile-sub">Info lingkungan</div>
      </div>
    </a>
    <a href="{{ route('portal.agenda') }}" class="portal-tile">
      <div class="tile-icon"><i class="bi bi-calendar-event"></i></div>
      <div>
        <div class="tile-title">Agenda</div>
        <div class="tile-sub">Kegiatan warga</div>
      </div>
    </a>
  </div>

  <div class="portal-section-title">Agenda Mendatang</div>
  @forelse ($agendas as $item)
    <a href="{{ route('portal.pengumuman.show', $item) }}" class="portal-list-item">
      <div class="portal-date-badge">
        <div style="font-size: 0.65rem; text-transform: uppercase;">{{ $item->tanggal_mulai->locale('id')->translatedFormat('M') }}</div>
        <div style="font-size: 1.1rem; line-height: 1;">{{ $item->tanggal_mulai->format('d') }}</div>
      </div>
      <div class="flex-grow-1">
        <div class="fw-semibold" style="font-size: 0.9rem;">{{ $item->judul }}</div>
        <small class="text-muted">
          <i class="bi bi-clock me-1"></i>{{ $item->waktu_mulai ?? '--:--' }}
          @if ($item->lokasi)
            <i class="bi bi-geo-alt ms-2 me-1"></i>{{ $item->lokasi }}
          @endif
        </small>
      </div>
      <i class="bi bi-chevron-right text-muted"></i>
    </a>
  @empty
    <div class="card-custom p-3 text-muted" style="font-size: 0.85rem;">Belum ada agenda mendatang.</div>
  @endforelse

  <div class="portal-section-title">Info Terbaru</div>
  @forelse ($pengumumans as $item)
    <a href="{{ route('portal.pengumuman.show', $item) }}" class="portal-list-item">
      <div class="tile-icon"><i class="bi bi-megaphone"></i></div>
      <div class="flex-grow-1">
        <div class="fw-semibold" style="font-size: 0.9rem;">{{ $item->judul }}</div>
        <small class="text-muted">{{ \Illuminate\Support\Str::limit($item->isi, 60) }}</small>
      </div>
      <i class="bi bi-chevron-right text-muted"></i>
    </a>
  @empty
    <div class="card-custom p-3 text-muted" style="font-size: 0.85rem;">Belum ada pengumuman.</div>
  @endforelse

  <div class="portal-section-title">Surat Saya</div>
  @forelse ($surats as $surat)
    <a href="{{ route('portal.surat.show', $surat) }}" class="portal-list-item">
      <div class="tile-icon"><i class="bi bi-file-earmark-text"></i></div>
      <div class="flex-grow-1">
        <div class="fw-semibold" style="font-size: 0.9rem;">{{ $surat->jenis_surat }}</div>
        <small class="text-muted">{{ $surat->tanggal_pengajuan?->format('d M Y') }} - {{ $surat->no_surat }}</small>
      </div>
      <span class="badge badge-soft-{{ $badgeMap[$surat->status] ?? 'info' }}">{{ $surat->status }}</span>
    </a>
  @empty
    <div class="card-custom p-3 d-flex justify-content-between align-items-center">
      <span class="text-muted" style="font-size: 0.85rem;">Anda belum pernah mengajukan surat.</span>
      <a href="{{ route('portal.surat.create') }}" class="btn btn-sm btn-primary-green">Ajukan</a>
    </div>
  @endforelse
@endsection
