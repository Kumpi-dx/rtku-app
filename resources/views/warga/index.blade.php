@extends('layouts.app')

@section('title', 'Data Warga - Sistem Informasi Manajemen RT/RW')
@section('page', 'warga')

@php
  $domisiliBadge = ['Tetap' => 'success', 'Kontrak' => 'info', 'Pindah' => 'warning'];
@endphp

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Data Kewargaan RT 005</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Pengelolaan data penduduk terdaftar secara transparan dan terstruktur.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('warga.export') }}" class="btn btn-sm btn-outline-success">
        <i class="bi bi-file-earmark-excel"></i>Export CSV
      </a>
      <a href="{{ route('warga.create') }}" class="btn btn-sm btn-primary-green">
        <i class="bi bi-person-plus-fill"></i>Tambah Warga
      </a>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.875rem;">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card-custom p-3 mb-3">
    <form method="GET" action="{{ route('warga.index') }}" class="row g-2">
      <div class="col-12 col-md-4">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari Nama / NIK...">
      </div>
      <div class="col-6 col-md-3">
        <select name="jenis_kelamin" class="form-select form-select-sm">
          <option value="">Semua Gender</option>
          <option value="Laki-laki" @selected(request('jenis_kelamin') === 'Laki-laki')>Laki-laki</option>
          <option value="Perempuan" @selected(request('jenis_kelamin') === 'Perempuan')>Perempuan</option>
        </select>
      </div>
      <div class="col-6 col-md-3">
        <select name="status_perkawinan" class="form-select form-select-sm">
          <option value="">Status Perkawinan</option>
          @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
            <option value="{{ $status }}" @selected(request('status_perkawinan') === $status)>{{ $status }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-primary-green w-100"><i class="bi bi-search"></i></button>
        <a href="{{ route('warga.index') }}" class="btn btn-sm btn-light"><i class="bi bi-x-lg"></i></a>
      </div>
    </form>
  </div>

  @if ($totalPendingWarga > 0)
    <div class="card-custom p-3 mb-3">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
          <h6 class="font-heading fw-bold mb-0"><i class="bi bi-exclamation-circle me-1 text-warning"></i>Warga Belum Melengkapi Data</h6>
          <small class="text-muted">Akun warga yang belum mengisi data kewarganegaraan.</small>
        </div>
        <span class="badge badge-soft-warning">Menunggu Perbaikan</span>
      </div>
      <div class="table-responsive">
        <table class="table table-custom mb-0">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Email Aktif</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($pendingWarga as $pending)
              <tr>
                <td class="fw-medium">{{ $pending->name }}</td>
                <td>{{ $pending->email }}</td>
                <td><span class="badge badge-soft-warning">Belum Melengkapi NIK</span></td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center text-muted py-4">Semua akun warga telah melengkapi data kewarganegaraan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  @endif

  <div class="card-custom">
    <div class="table-responsive">
      <table class="table table-custom mb-0" id="wargaTable">
        <thead>
          <tr>
            <th>NIK</th>
            <th>Nama Lengkap</th>
            <th>L/P</th>
            <th>No. Telp</th>
            <th>Pekerjaan</th>
            <th>Status Domisili</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($wargas as $warga)
            <tr>
              <td class="fw-medium">{{ $warga->nik }}</td>
              <td>{{ $warga->nama_lengkap }}</td>
              <td>{{ $warga->jenis_kelamin }}</td>
              <td>{{ $warga->no_telp ?? '-' }}</td>
              <td>{{ $warga->pekerjaan ?? '-' }}</td>
              <td><span class="badge badge-soft-{{ $domisiliBadge[$warga->status_domisili] ?? 'secondary' }}">{{ $warga->status_domisili }}</span></td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  <a href="{{ route('warga.show', $warga) }}" class="btn btn-xs btn-light" title="Detail"><i class="bi bi-eye"></i></a>
                  <a href="{{ route('warga.edit', $warga) }}" class="btn btn-xs btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                  <form action="{{ route('warga.destroy', $warga) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data warga {{ $warga->nama_lengkap }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">Tidak ada data warga yang cocok.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3 border-top border-color d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.85rem;">
      <span class="text-muted">Menampilkan {{ $wargas->firstItem() ?? 0 }}-{{ $wargas->lastItem() ?? 0 }} dari {{ $wargas->total() }} warga</span>
      {{ $wargas->links() }}
    </div>
  </div>
@endsection
