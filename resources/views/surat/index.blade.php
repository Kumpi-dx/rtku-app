@extends('layouts.app')

@section('title', 'Administrasi Surat - Sistem Informasi Manajemen RT/RW')
@section('page', 'surat')

@php
  $badgeMap = ['Pending' => 'warning', 'Diproses' => 'info', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
@endphp

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Pengelolaan Surat Administrasi</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Pengajuan dan penerbitan surat pengantar resmi RT/RW.</p>
    </div>
    <a href="{{ route('surat.create') }}" class="btn btn-sm btn-primary-green">
      <i class="bi bi-plus-lg"></i>Buat Permohonan Surat
    </a>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.875rem;">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card-custom p-3 mb-3">
    <form method="GET" action="{{ route('surat.index') }}" class="row g-2">
      <div class="col-12 col-md-5">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari No. Surat / Pemohon / Jenis...">
      </div>
      <div class="col-8 col-md-4">
        <select name="status" class="form-select form-select-sm">
          <option value="">Semua Status</option>
          @foreach (['Pending', 'Diproses', 'Disetujui', 'Ditolak'] as $status)
            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-4 col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-primary-green w-100"><i class="bi bi-search"></i></button>
        <a href="{{ route('surat.index') }}" class="btn btn-sm btn-light"><i class="bi bi-x-lg"></i></a>
      </div>
    </form>
  </div>

  <div class="card-custom">
    <div class="table-responsive">
      <table class="table table-custom mb-0">
        <thead>
          <tr>
            <th>No. Surat</th>
            <th>Pemohon</th>
            <th>Jenis Surat</th>
            <th>Keperluan</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($surats as $surat)
            <tr>
              <td><code>{{ $surat->no_surat }}</code></td>
              <td class="fw-medium">{{ $surat->warga?->nama_lengkap ?? '-' }}</td>
              <td>{{ $surat->jenis_surat }}</td>
              <td>{{ \Illuminate\Support\Str::limit($surat->keperluan, 40) }}</td>
              <td>{{ $surat->tanggal_pengajuan?->format('d M Y') ?? '-' }}</td>
              <td><span class="badge badge-soft-{{ $badgeMap[$surat->status] ?? 'info' }}">{{ $surat->status }}</span></td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  <a href="{{ route('surat.show', $surat) }}" class="btn btn-xs btn-light" title="Detail / Cetak"><i class="bi bi-eye"></i></a>
                  <a href="{{ route('surat.edit', $surat) }}" class="btn btn-xs btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                  <form action="{{ route('surat.destroy', $surat) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus surat {{ $surat->no_surat }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Belum ada data surat.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3 border-top border-color d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.85rem;">
      <span class="text-muted">Menampilkan {{ $surats->firstItem() ?? 0 }}-{{ $surats->lastItem() ?? 0 }} dari {{ $surats->total() }} surat</span>
      {{ $surats->links() }}
    </div>
  </div>
@endsection
