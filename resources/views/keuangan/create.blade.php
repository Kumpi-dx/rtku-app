@extends('layouts.app')

@section('title', 'Catat Transaksi Kas - Sistem Informasi Manajemen RT/RW')
@section('page', 'keuangan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Catat Transaksi Kas</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Tambahkan pemasukan atau pengeluaran kas RT.</p>
    </div>
    <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3" style="max-width: 800px;">
    <form action="{{ route('keuangan.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Tanggal</label>
          <input type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Tipe</label>
          <select name="tipe" id="tipeTransaksi" class="form-select form-select-sm" required>
            <option value="pemasukan" @selected(old('tipe', request('tipe')) === 'pemasukan')>Pemasukan</option>
            <option value="pengeluaran" @selected(old('tipe', request('tipe')) === 'pengeluaran')>Pengeluaran</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Kategori</label>
          <select name="kategori_keuangan_id" class="form-select form-select-sm" required>
            <option value="">Pilih kategori</option>
            @foreach ($kategoris as $kategori)
              <option value="{{ $kategori->id }}" data-tipe="{{ $kategori->tipe }}" @selected(old('kategori_keuangan_id') == $kategori->id)>{{ $kategori->nama }} ({{ ucfirst($kategori->tipe) }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Keterangan</label>
          <input type="text" name="keterangan" value="{{ old('keterangan') }}" class="form-control form-control-sm" required placeholder="Contoh: Iuran Bpk Budi">
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Nominal (Rp)</label>
          <input type="number" name="nominal" value="{{ old('nominal') }}" min="0" class="form-control form-control-sm" required placeholder="100000">
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Transaksi</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    document.getElementById('tipeTransaksi')?.addEventListener('change', function () {
      var tipe = this.value;
      document.querySelectorAll('select[name="kategori_keuangan_id"] option[data-tipe]').forEach(function (option) {
        option.hidden = option.dataset.tipe !== tipe;
      });
    });
  </script>
@endpush
