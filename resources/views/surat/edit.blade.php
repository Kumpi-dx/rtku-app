@extends('layouts.app')

@section('title', 'Edit Surat - Sistem Informasi Manajemen RT/RW')
@section('page', 'surat')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Edit Permohonan Surat</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Nomor: <code>{{ $surat->no_surat }}</code></p>
    </div>
    <a href="{{ route('surat.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3" style="max-width: 900px;">
    <form action="{{ route('surat.update', $surat) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label small fw-semibold">Nama Pemohon</label>
          <select name="warga_id" class="form-select form-select-sm" required>
            @foreach ($wargas as $warga)
              <option value="{{ $warga->id }}" @selected(old('warga_id', $surat->warga_id) == $warga->id)>{{ $warga->nama_lengkap }} - NIK {{ $warga->nik }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Jenis Surat</label>
          <input type="text" name="jenis_surat" value="{{ old('jenis_surat', $surat->jenis_surat) }}" class="form-control form-control-sm" required>
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label small fw-semibold">Status</label>
          <select name="status" class="form-select form-select-sm" required>
            @foreach (['Pending', 'Diproses', 'Disetujui', 'Ditolak'] as $status)
              <option value="{{ $status }}" @selected(old('status', $surat->status) === $status)>{{ $status }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Keperluan / Alasan</label>
          <textarea name="keperluan" class="form-control form-control-sm" rows="4" required>{{ old('keperluan', $surat->keperluan) }}</textarea>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Keterangan</label>
          <textarea name="keterangan" class="form-control form-control-sm" rows="3">{{ old('keterangan', $surat->keterangan) }}</textarea>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('surat.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Simpan Perubahan</button>
      </div>
    </form>
  </div>
@endsection
