@extends('layouts.app')

@section('title', 'Detail Surat - Sistem Informasi Manajemen RT/RW')
@section('page', 'surat')

@php
  $badgeMap = ['Pending' => 'warning', 'Diproses' => 'info', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
@endphp

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Detail Permohonan Surat</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Nomor: <code>{{ $surat->no_surat }}</code></p>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#previewSuratModal">
        <i class="bi bi-printer"></i>Cetak
      </button>
      <a href="{{ route('surat.index') }}" class="btn btn-sm btn-light">
        <i class="bi bi-arrow-left"></i>Kembali
      </a>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.875rem;">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-3">
    <div class="col-12 col-lg-7">
      <div class="card-custom p-3">
        <h6 class="font-heading fw-bold mb-3">Informasi Surat</h6>
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <small class="text-muted d-block mb-1">Pemohon</small>
            <div class="fw-semibold">{{ $surat->warga?->nama_lengkap ?? '-' }}</div>
          </div>
          <div class="col-12 col-md-6">
            <small class="text-muted d-block mb-1">NIK</small>
            <div class="fw-semibold">{{ $surat->warga?->nik ?? '-' }}</div>
          </div>
          <div class="col-12 col-md-6">
            <small class="text-muted d-block mb-1">Jenis Surat</small>
            <div class="fw-semibold">{{ $surat->jenis_surat }}</div>
          </div>
          <div class="col-12 col-md-6">
            <small class="text-muted d-block mb-1">Status</small>
            <div><span class="badge badge-soft-{{ $badgeMap[$surat->status] ?? 'info' }}">{{ $surat->status }}</span></div>
          </div>
          <div class="col-12 col-md-6">
            <small class="text-muted d-block mb-1">Tanggal Pengajuan</small>
            <div class="fw-semibold">{{ $surat->tanggal_pengajuan?->format('d M Y') ?? '-' }}</div>
          </div>
          <div class="col-12 col-md-6">
            <small class="text-muted d-block mb-1">Tanggal Disetujui</small>
            <div class="fw-semibold">{{ $surat->tanggal_disetujui?->format('d M Y') ?? '-' }}</div>
          </div>
          <div class="col-12">
            <small class="text-muted d-block mb-1">Keperluan</small>
            <div class="fw-semibold">{{ $surat->keperluan }}</div>
          </div>
          <div class="col-12">
            <small class="text-muted d-block mb-1">Keterangan</small>
            <div class="fw-semibold">{{ $surat->keterangan ?? '-' }}</div>
          </div>
          <div class="col-12">
            <small class="text-muted d-block mb-1">Ditandatangani Oleh</small>
            <div class="fw-semibold">{{ $surat->ditandatangani_oleh ?? '-' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-5">
      <div class="card-custom p-3">
        <h6 class="font-heading fw-bold mb-3">Perbarui Status</h6>
        <form action="{{ route('surat.status', $surat) }}" method="POST">
          @csrf
          @method('PATCH')
          <div class="mb-3">
            <label class="form-label small fw-semibold">Status</label>
            <select name="status" class="form-select form-select-sm">
              @foreach (['Pending', 'Diproses', 'Disetujui', 'Ditolak'] as $status)
                <option value="{{ $status }}" @selected($surat->status === $status)>{{ $status }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Keterangan</label>
            <textarea name="keterangan" rows="3" class="form-control form-control-sm">{{ $surat->keterangan }}</textarea>
          </div>
          <button type="submit" class="btn btn-sm btn-primary-green w-100">Simpan Status</button>
        </form>
        <div class="d-flex gap-2 mt-3">
          <a href="{{ route('surat.edit', $surat) }}" class="btn btn-sm btn-outline-success flex-grow-1"><i class="bi bi-pencil"></i>Edit</a>
          <form action="{{ route('surat.destroy', $surat) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Hapus surat ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-trash"></i>Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="previewSuratModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content card-custom border-0">
        <div class="modal-header border-bottom border-color">
          <h5 class="modal-title font-heading fw-bold">Preview Cetak Surat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="surat-preview-paper">
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
            <div class="d-flex justify-content-between mt-5 pt-4">
              <div></div>
              <div class="text-center">
                <div>Depok, {{ ($surat->tanggal_disetujui ?? now())->locale('id')->translatedFormat('d F Y') }}</div>
                <div>Ketua RT 005</div>
                <div style="height: 60px;"></div>
                <strong>( {{ $surat->ditandatangani_oleh ?? 'H. Bambang S.' }} )</strong>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top border-color">
          <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-sm btn-primary-green" onclick="window.print()"><i class="bi bi-printer"></i>Cetak Surat</button>
        </div>
      </div>
    </div>
  </div>
@endsection
