@extends('layouts.app')

@section('title', 'Buat Permohonan Surat - Sistem Informasi Manajemen RT/RW')
@section('page', 'surat')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Buat Permohonan Surat</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Ajukan surat pengantar resmi RT/RW.</p>
    </div>
    <a href="{{ route('surat.index') }}" class="btn btn-sm btn-light">
      <i class="bi bi-arrow-left"></i>Kembali
    </a>
  </div>

  <div class="card-custom p-3" style="max-width: 900px;">
    <form action="{{ route('surat.store') }}" method="POST">
      @csrf

      <div class="row g-3">
        <div class="col-12">
          <label class="form-label small fw-semibold">Nama Pemohon</label>
          <select name="warga_id" class="form-select form-select-sm" required>
            <option value="">Pilih warga pemohon</option>
            @foreach ($wargas as $warga)
              <option value="{{ $warga->id }}" @selected(old('warga_id') == $warga->id)>{{ $warga->nama_lengkap }} - NIK {{ $warga->nik }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Jenis Surat</label>
          <select name="jenis_surat" class="form-select form-select-sm" required>
            <option>Surat Keterangan Domisili</option>
            <option>Surat Keterangan Tidak Mampu</option>
            <option>Surat Keterangan Usaha</option>
            <option>Surat Pengantar Umum</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label small fw-semibold">Keperluan / Alasan</label>
          <textarea name="keperluan" class="form-control form-control-sm" rows="4" required placeholder="Tuliskan alasan pengajuan..."></textarea>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('surat.index') }}" class="btn btn-sm btn-light">Batal</a>
        <button type="submit" class="btn btn-sm btn-primary-green">Ajukan Surat</button>
      </div>
    </form>
  </div>
@endsection
