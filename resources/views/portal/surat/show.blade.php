@extends('layouts.portal')

@section('title', 'Detail Surat - Portal Warga SiRT-RW')

@php
  $badgeMap = ['Pending' => 'warning', 'Diproses' => 'info', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
@endphp

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h5 class="font-heading fw-bold mb-1">Detail Surat</h5>
      <p class="text-muted mb-0" style="font-size: 0.85rem;">{{ $surat->no_surat }}</p>
    </div>
    <a href="{{ route('portal.surat') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i>Kembali</a>
  </div>

  <div class="card-custom p-3 mb-3">
    <div class="d-flex justify-content-between align-items-start mb-3">
      <div>
        <div class="fw-bold font-heading" style="font-size: 1.05rem;">{{ $surat->jenis_surat }}</div>
        <small class="text-muted">{{ $surat->no_surat }}</small>
      </div>
      <span class="badge badge-soft-{{ $badgeMap[$surat->status] ?? 'info' }}">{{ $surat->status }}</span>
    </div>

    <div class="row g-3" style="font-size: 0.85rem;">
      <div class="col-6">
        <small class="text-muted d-block">Tanggal Pengajuan</small>
        <span class="fw-semibold">{{ $surat->tanggal_pengajuan?->format('d M Y') ?? '-' }}</span>
      </div>
      <div class="col-6">
        <small class="text-muted d-block">Tanggal Disetujui</small>
        <span class="fw-semibold">{{ $surat->tanggal_disetujui?->format('d M Y') ?? '-' }}</span>
      </div>
      <div class="col-12">
        <small class="text-muted d-block">Keperluan</small>
        <span class="fw-semibold">{{ $surat->keperluan }}</span>
      </div>
      <div class="col-12">
        <small class="text-muted d-block">Keterangan Pengurus</small>
        <span class="fw-semibold">{{ $surat->keterangan ?? '-' }}</span>
      </div>
    </div>
  </div>

  @if ($surat->status === 'Disetujui')
    <button class="btn btn-primary-green w-100" data-bs-toggle="modal" data-bs-target="#previewSuratModal">
      <i class="bi bi-printer me-1"></i>Lihat & Cetak Surat
    </button>
  @else
    <div class="alert alert-light border mb-0" style="font-size: 0.83rem;">
      <i class="bi bi-hourglass-split me-1 text-warning"></i>
      Surat dapat dicetak setelah disetujui pengurus.
    </div>
  @endif

  <div class="modal fade" id="previewSuratModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0">
        <div class="modal-header">
          <h6 class="modal-title font-heading fw-bold">Surat Keterangan</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="text-center border-bottom border-2 border-dark pb-3 mb-4">
            <h5 class="fw-bold mb-0 text-uppercase">Rukun Tetangga 005 / Rukun Warga 012</h5>
            <h6 class="fw-bold mb-0 text-uppercase">Kelurahan Sukamaju, Kecamatan Cilodong</h6>
            <small>Kota Depok, Jawa Barat 16413</small>
          </div>
          <div class="text-center mb-4">
            <u class="fw-bold h6 d-block mb-0">{{ strtoupper($surat->jenis_surat) }}</u>
            <small>Nomor: {{ $surat->no_surat }}</small>
          </div>
          <p>Yang bertanda tangan di bawah ini Ketua RT 005 / RW 012 Kelurahan Sukamaju, dengan ini menerangkan bahwa:</p>
          <table class="table table-borderless table-sm my-3" style="width: 100%;">
            <tr><td style="width: 30%;">Nama Lengkap</td><td>: <strong>{{ $surat->warga?->nama_lengkap }}</strong></td></tr>
            <tr><td>NIK</td><td>: {{ $surat->warga?->nik }}</td></tr>
            <tr><td>Keperluan</td><td>: {{ $surat->keperluan }}</td></tr>
          </table>
          <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
          <div class="d-flex justify-content-end mt-5 pt-4">
            <div class="text-center">
              <div>Depok, {{ ($surat->tanggal_disetujui ?? now())->locale('id')->translatedFormat('d F Y') }}</div>
              <div>Ketua RT 005</div>
              <div style="height: 60px;"></div>
              <strong>( {{ $surat->ditandatangani_oleh ?? 'H. Bambang S.' }} )</strong>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-sm btn-primary-green" onclick="window.print()"><i class="bi bi-printer me-1"></i>Cetak</button>
        </div>
      </div>
    </div>
  </div>
@endsection
