@extends('layouts.app')

@section('title', 'Iuran Warga - Sistem Informasi Manajemen RT/RW')
@section('page', 'keuangan')

@php
  $badgeMap = ['Belum Lunas' => 'danger', 'Lunas' => 'success', 'Sebagian' => 'warning'];
@endphp

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Iuran Warga</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Pencatatan dan pemantauan iuran kas bulanan warga.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i>Kas</a>
      <a href="{{ route('iuran.create') }}" class="btn btn-sm btn-primary-green"><i class="bi bi-plus-lg"></i>Tambah Iuran</a>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.875rem;">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-3 mb-3">
    <div class="col-12 col-md-4">
      <div class="card-custom p-3 border-start border-4 border-primary">
        <small class="text-muted d-block mb-1">Total Tagihan</small>
        <h5 class="font-heading fw-bold mb-0">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</h5>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card-custom p-3 border-start border-4 border-success">
        <small class="text-muted d-block mb-1">Total Lunas</small>
        <h5 class="font-heading fw-bold mb-0 text-success">Rp {{ number_format($totalLunas, 0, ',', '.') }}</h5>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card-custom p-3 border-start border-4 border-danger">
        <small class="text-muted d-block mb-1">Total Tunggakan</small>
        <h5 class="font-heading fw-bold mb-0 text-danger">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</h5>
      </div>
    </div>
  </div>

  <div class="card-custom p-3 mb-3">
    <form method="GET" action="{{ route('iuran.index') }}" class="row g-2">
      <div class="col-12 col-md-4">
        <select name="warga_id" class="form-select form-select-sm">
          <option value="">Semua Warga</option>
          @foreach ($wargas as $warga)
            <option value="{{ $warga->id }}" @selected((int) request('warga_id') === $warga->id)>{{ $warga->nama_lengkap }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-6 col-md-3">
        <input type="month" name="periode" value="{{ request('periode') }}" class="form-control form-control-sm">
      </div>
      <div class="col-6 col-md-3">
        <select name="status" class="form-select form-select-sm">
          <option value="">Semua Status</option>
          @foreach (['Belum Lunas', 'Lunas', 'Sebagian'] as $status)
            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-primary-green w-100"><i class="bi bi-search"></i></button>
        <a href="{{ route('iuran.index') }}" class="btn btn-sm btn-light"><i class="bi bi-x-lg"></i></a>
      </div>
    </form>
  </div>

  <div class="card-custom">
    <div class="table-responsive">
      <table class="table table-custom mb-0">
        <thead>
          <tr>
            <th>Warga</th>
            <th>Periode</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Tanggal Bayar</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($iurans as $iuran)
            <tr>
              <td class="fw-medium">{{ $iuran->warga?->nama_lengkap ?? '-' }}</td>
              <td>{{ $iuran->periode }}</td>
              <td>Rp {{ number_format($iuran->jumlah, 0, ',', '.') }}</td>
              <td><span class="badge badge-soft-{{ $badgeMap[$iuran->status] ?? 'secondary' }}">{{ $iuran->status }}</span></td>
              <td>{{ $iuran->tanggal_bayar?->format('d/m/Y') ?? '-' }}</td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  <a href="{{ route('iuran.edit', $iuran) }}" class="btn btn-xs btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                  <form action="{{ route('iuran.destroy', $iuran) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data iuran ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Belum ada data iuran.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3 border-top border-color d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.85rem;">
      <span class="text-muted">Menampilkan {{ $iurans->firstItem() ?? 0 }}-{{ $iurans->lastItem() ?? 0 }} dari {{ $iurans->total() }} data</span>
      {{ $iurans->links() }}
    </div>
  </div>
@endsection
