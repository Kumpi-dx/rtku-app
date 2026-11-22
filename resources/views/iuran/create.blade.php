@extends('layouts.app')

@section('title', 'Tambah Iuran - Sistem Informasi Manajemen RT/RW')
@section('page', 'keuangan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Tambah Data Iuran</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Catat iuran kas warga untuk periode tertentu.</p>
    </div>
    <a href="{{ route('iuran.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i>Kembali</a>
  </div>

  <div class="card-custom p-3" style="max-width: 700px;">
    <form action="{{ route('iuran.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label small fw-semibold">Warga</label>
          <select name="warga_id" class="form-select form-select-sm" required>
            <option value="">Pilih warga</option>
            @foreach ($wargas as $warga)
              <option value="{{ $warga->id }}" @selected(old('warga_id') == $warga->id)>{{ $warga->nama_lengkap }} - NIK {{ $warga->nik }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Periode</label>
          <input type="month" name="periode" value="{{ old('periode', now()->format('Y-m')) }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Jumlah (Rp)</label>
          <input type="number" name="jumlah" value="{{ old('jumlah', 100000) }}" min="0" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Status</label>
          <select name="status" class="form-select form-select-sm" required>
            @foreach (['Belum Lunas', 'Lunas', 'Sebagian'] as $status)
              <option value="{{ $status }}" @selected(old('status') === $status)>{{ $status }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Tanggal Bayar (opsional)</label>
          <input type="date" name="tanggal_bayar" value="{{ old('tanggal_bayar') }}" class="form-control form-control-sm">
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('iuran.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Iuran</button>
      </div>
    </form>
  </div>
@endsection
