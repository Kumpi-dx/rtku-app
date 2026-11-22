@extends('layouts.portal')

@section('title', 'Ajukan Surat - Portal Warga SiRT-RW')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h5 class="font-heading fw-bold mb-1">Ajukan Surat</h5>
      <p class="text-muted mb-0" style="font-size: 0.85rem;">Isi data di bawah, pengurus akan memproses permohonan Anda.</p>
    </div>
    <a href="{{ route('portal.surat') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i>Kembali</a>
  </div>

  <div class="card-custom p-3">
    <div class="alert alert-light border" style="font-size: 0.83rem;">
      <i class="bi bi-person-check me-1 text-primary-green"></i>
      Pemohon: <strong>{{ $warga->nama_lengkap }}</strong> (NIK {{ $warga->nik }})
    </div>

    <form action="{{ route('portal.surat.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label small fw-semibold">Jenis Surat</label>
        <select name="jenis_surat" class="form-select" required>
          <option value="">Pilih jenis surat</option>
          <option value="Surat Keterangan Domisili" @selected(old('jenis_surat') === 'Surat Keterangan Domisili')>Surat Keterangan Domisili</option>
          <option value="Surat Keterangan Tidak Mampu" @selected(old('jenis_surat') === 'Surat Keterangan Tidak Mampu')>Surat Keterangan Tidak Mampu</option>
          <option value="Surat Keterangan Usaha" @selected(old('jenis_surat') === 'Surat Keterangan Usaha')>Surat Keterangan Usaha</option>
          <option value="Surat Pengantar Umum" @selected(old('jenis_surat') === 'Surat Pengantar Umum')>Surat Pengantar Umum</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label small fw-semibold">Keperluan</label>
        <textarea name="keperluan" rows="4" class="form-control" required placeholder="Contoh: untuk pembukaan rekening bank">{{ old('keperluan') }}</textarea>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary-green">Kirim Permohonan</button>
      </div>
    </form>
  </div>
@endsection
