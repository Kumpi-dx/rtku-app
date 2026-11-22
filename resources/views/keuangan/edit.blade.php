@extends('layouts.app')

@section('title', 'Edit Transaksi Kas - Sistem Informasi Manajemen RT/RW')
@section('page', 'keuangan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Edit Transaksi Kas</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Perbarui data transaksi kas RT.</p>
    </div>
    <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3" style="max-width: 800px;">
    <form action="{{ route('keuangan.update', $keuangan) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Tanggal</label>
          <input type="date" name="tanggal" value="{{ old('tanggal', $keuangan->tanggal?->toDateString()) }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Tipe</label>
          <select name="tipe" class="form-select form-select-sm" required>
            <option value="pemasukan" @selected(old('tipe', $keuangan->tipe) === 'pemasukan')>Pemasukan</option>
            <option value="pengeluaran" @selected(old('tipe', $keuangan->tipe) === 'pengeluaran')>Pengeluaran</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Kategori</label>
          <select name="kategori_keuangan_id" class="form-select form-select-sm" required>
            @foreach ($kategoris as $kategori)
              <option value="{{ $kategori->id }}" @selected(old('kategori_keuangan_id', $keuangan->kategori_keuangan_id) == $kategori->id)>{{ $kategori->nama }} ({{ ucfirst($kategori->tipe) }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Keterangan</label>
          <input type="text" name="keterangan" value="{{ old('keterangan', $keuangan->keterangan) }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Nominal (Rp)</label>
          <input type="number" name="nominal" value="{{ old('nominal', $keuangan->nominal) }}" min="0" class="form-control form-control-sm" required>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Perubahan</button>
      </div>
    </form>
  </div>
@endsection
