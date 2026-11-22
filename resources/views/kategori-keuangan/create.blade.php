@extends('layouts.app')

@section('title', 'Tambah Kategori Keuangan - Sistem Informasi Manajemen RT/RW')
@section('page', 'keuangan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Tambah Kategori Keuangan</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Buat kategori baru untuk transaksi kas RT.</p>
    </div>
    <a href="{{ route('kategori-keuangan.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i>Kembali</a>
  </div>

  <div class="card-custom p-3" style="max-width: 700px;">
    <form action="{{ route('kategori-keuangan.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Nama Kategori</label>
          <input type="text" name="nama" value="{{ old('nama') }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Tipe</label>
          <select name="tipe" class="form-select form-select-sm" required>
            <option value="pemasukan" @selected(old('tipe') === 'pemasukan')>Pemasukan</option>
            <option value="pengeluaran" @selected(old('tipe') === 'pengeluaran')>Pengeluaran</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Keterangan</label>
          <textarea name="keterangan" rows="3" class="form-control form-control-sm">{{ old('keterangan') }}</textarea>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('kategori-keuangan.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Kategori</button>
      </div>
    </form>
  </div>
@endsection
