@extends('layouts.app')

@section('title', 'Detail Warga - Sistem Informasi Manajemen RT/RW')
@section('page', 'warga')

@php
  $suratBadgeMap = ['Pending' => 'warning', 'Diproses' => 'info', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
  $iuranBadgeMap = ['Belum Lunas' => 'danger', 'Lunas' => 'success', 'Sebagian' => 'warning'];
@endphp

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Detail Warga</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Profil dan data terkait warga RT 005 / RW 012 Sukamaju.</p>
    </div>
    <a href="{{ route('warga.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3 mb-3">
    <div class="d-flex align-items-center gap-3 mb-3">
      <div class="bg-soft-green text-primary-green rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; font-size: 1.6rem;">
        <i class="bi bi-person"></i>
      </div>
      <div>
        <h5 class="font-heading fw-bold mb-0">{{ $warga->nama_lengkap }}</h5>
        <small class="text-muted">NIK: {{ $warga->nik }}</small>
      </div>
    </div>
    <div class="row g-3">
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Jenis Kelamin</small>
        <div class="fw-semibold">{{ $warga->jenis_kelamin }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">No. Telepon / WA</small>
        <div class="fw-semibold">{{ $warga->no_telp ?? '-' }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Pekerjaan</small>
        <div class="fw-semibold">{{ $warga->pekerjaan ?? '-' }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Status Domisili</small>
        <div class="fw-semibold">{{ $warga->status_domisili }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Status Perkawinan</small>
        <div class="fw-semibold">{{ $warga->status_perkawinan ?? 'Belum Kawin' }}</div>
      </div>
      <div class="col-12 col-md-4">
        <small class="text-muted d-block mb-1">Alamat</small>
        <div class="fw-semibold">{{ $warga->alamat ?? '-' }}</div>
      </div>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-3">
      <a href="{{ route('warga.edit', $warga) }}" class="btn btn-sm btn-outline-success">
        <i class="bi bi-pencil"></i>Edit Warga
      </a>
      <form action="{{ route('warga.destroy', $warga) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
          <i class="bi bi-trash"></i>Hapus Warga
        </button>
      </form>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-6">
      <div class="card-custom p-3">
        <h6 class="font-heading fw-bold mb-3">Surat Pengantar ({{ $warga->surats->count() }})</h6>
        @if ($warga->surats->isEmpty())
          <p class="text-muted mb-0">Belum ada surat pengantar untuk warga ini.</p>
        @else
          <div class="table-responsive">
            <table class="table table-custom mb-0">
              <thead>
                <tr>
                  <th>No. Surat</th>
                  <th>Jenis Surat</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($warga->surats as $surat)
                  <tr>
                    <td class="fw-medium"><code>{{ $surat->no_surat }}</code></td>
                    <td>{{ $surat->jenis_surat }}</td>
                    <td>{{ $surat->tanggal_pengajuan->format('d M Y') }}</td>
                    <td><span class="badge badge-soft-{{ $suratBadgeMap[$surat->status] ?? 'info' }}">{{ $surat->status }}</span></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
    <div class="col-12 col-lg-6">
      <div class="card-custom p-3">
        <h6 class="font-heading fw-bold mb-3">Iuran Kas ({{ $warga->iurans->count() }})</h6>
        @if ($warga->iurans->isEmpty())
          <p class="text-muted mb-0">Belum ada data iuran untuk warga ini.</p>
        @else
          <div class="table-responsive">
            <table class="table table-custom mb-0">
              <thead>
                <tr>
                  <th>Periode</th>
                  <th>Jumlah</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($warga->iurans as $iuran)
                  <tr>
                    <td class="fw-medium">{{ $iuran->periode }}</td>
                    <td>Rp {{ number_format($iuran->jumlah) }}</td>
                    <td><span class="badge badge-soft-{{ $iuranBadgeMap[$iuran->status] ?? 'danger' }}">{{ $iuran->status }}</span></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
