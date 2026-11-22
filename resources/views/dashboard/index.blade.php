@extends('layouts.app')

@section('title', 'Dashboard - Sistem Informasi Manajemen RT/RW')
@section('page', 'dashboard')

@php
  $suratBadgeMap = ['Pending' => 'warning', 'Diproses' => 'info', 'Disetujui' => 'success', 'Ditolak' => 'danger'];
  $iuranBadgeMap = ['Belum Lunas' => 'danger', 'Lunas' => 'success', 'Sebagian' => 'warning'];
  $totalDemografi = max(1, $demografi['laki'] + $demografi['perempuan']);
@endphp

@push('scripts')
  <script>
    window.DASHBOARD_DATA = {
      chart: @json($chart),
      demografi: @json($demografi)
    };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Ringkasan Sistem RT 005</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Selamat datang di Dashboard Administrasi Lingkungan Sukamaju.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('surat.create') }}" class="btn btn-sm btn-outline-success">
        <i class="bi bi-plus-lg"></i>Buat Surat
      </a>
      <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary-green">
        <i class="bi bi-arrow-clockwise"></i>Refresh Data
      </a>
    </div>
  </div>

  <div class="row g-3 mb-4 stat-grid">
    <div class="col-12 col-sm-6 col-xl-2">
      <div class="card-custom stat-card">
        <div>
          <small class="text-muted fw-medium d-block mb-1">Total Warga</small>
          <h4 class="font-heading fw-bold mb-0">{{ number_format($totalWarga) }}</h4>
          <small class="text-success fw-semibold" style="font-size: 0.75rem;"><i class="bi bi-arrow-up-short"></i>Terdaftar</small>
        </div>
        <div class="stat-icon bg-soft-green text-primary-green"><i class="bi bi-people"></i></div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-2">
      <div class="card-custom stat-card">
        <div>
          <small class="text-muted fw-medium d-block mb-1">Kepala Keluarga</small>
          <h4 class="font-heading fw-bold mb-0">{{ number_format($totalKK) }}</h4>
          <small class="text-muted" style="font-size: 0.75rem;">KK Terdaftar</small>
        </div>
        <div class="stat-icon bg-mint-green text-primary-green"><i class="bi bi-house-door"></i></div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-2">
      <div class="card-custom stat-card">
        <div>
          <small class="text-muted fw-medium d-block mb-1">Laki-laki</small>
          <h4 class="font-heading fw-bold mb-0">{{ number_format($demografi['laki']) }}</h4>
          <small class="text-muted" style="font-size: 0.75rem;">{{ number_format($demografi['laki'] / $totalDemografi * 100, 1) }}% Total</small>
        </div>
        <div class="stat-icon bg-light-green text-primary-green"><i class="bi bi-gender-male"></i></div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-2">
      <div class="card-custom stat-card">
        <div>
          <small class="text-muted fw-medium d-block mb-1">Perempuan</small>
          <h4 class="font-heading fw-bold mb-0">{{ number_format($demografi['perempuan']) }}</h4>
          <small class="text-muted" style="font-size: 0.75rem;">{{ number_format($demografi['perempuan'] / $totalDemografi * 100, 1) }}% Total</small>
        </div>
        <div class="stat-icon bg-soft-green text-primary-green"><i class="bi bi-gender-female"></i></div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-2">
      <div class="card-custom stat-card">
        <div>
          <small class="text-muted fw-medium d-block mb-1">Iuran Bulan Ini</small>
          <h4 class="font-heading fw-bold mb-0 text-truncate" style="font-size: 1.1rem;">Rp {{ number_format($iuranBulanIni, 0, ',', '.') }}</h4>
          <small class="text-muted" style="font-size: 0.75rem;">Iuran Lunas</small>
        </div>
        <div class="stat-icon bg-mint-green text-primary-green"><i class="bi bi-cash-stack"></i></div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-2">
      <div class="card-custom stat-card">
        <div>
          <small class="text-muted fw-medium d-block mb-1">Total Kas RT</small>
          <h4 class="font-heading fw-bold mb-0 text-truncate" style="font-size: 1.1rem;">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
          <small class="text-success fw-semibold" style="font-size: 0.75rem;">Saldo Kas</small>
        </div>
        <div class="stat-icon bg-soft-green text-primary-green"><i class="bi bi-bank"></i></div>
      </div>
    </div>
  </div>

  <div class="card-custom p-3 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
      <div>
        <h6 class="font-heading fw-bold mb-0">Status Iuran Warga</h6>
        <small class="text-muted">Periode {{ \Illuminate\Support\Carbon::createFromFormat('Y-m', $periodeIuran)->locale('id')->translatedFormat('F Y') }}</small>
      </div>
      <div class="d-flex gap-2">
        <a href="{{ route('iuran.index', ['periode' => $periodeIuran]) }}" class="btn btn-sm btn-light"><i class="bi bi-list-check"></i>Lihat Semua</a>
        <a href="{{ route('iuran.create') }}" class="btn btn-sm btn-primary-green"><i class="bi bi-plus-lg"></i>Catat Iuran</a>
      </div>
    </div>

    <div class="iuran-summary mb-3">
      <div class="iuran-metric">
        <div class="iuran-metric-icon is-success"><i class="bi bi-check2-circle"></i></div>
        <div>
          <span class="iuran-metric-label">Sudah Lunas</span>
          <div class="iuran-metric-value">{{ $iuranLunas }} <small>dari {{ $totalWarga }} warga</small></div>
        </div>
      </div>
      <div class="iuran-metric">
        <div class="iuran-metric-icon is-warning"><i class="bi bi-circle-half"></i></div>
        <div>
          <span class="iuran-metric-label">Bayar Sebagian</span>
          <div class="iuran-metric-value">{{ $iuranSebagian }} <small>warga</small></div>
        </div>
      </div>
      <div class="iuran-metric is-danger">
        <div class="iuran-metric-icon is-danger"><i class="bi bi-exclamation-circle"></i></div>
        <div>
          <span class="iuran-metric-label">Belum Lunas</span>
          <div class="iuran-metric-value">{{ $iuranBelum }} <small>warga</small></div>
        </div>
      </div>
      <div class="iuran-metric is-danger">
        <div class="iuran-metric-icon is-danger"><i class="bi bi-wallet2"></i></div>
        <div>
          <span class="iuran-metric-label">Tunggakan Periode Ini</span>
          <div class="iuran-metric-value is-currency">Rp {{ number_format($tunggakanBulanIni, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 0.78rem;">
      <span class="text-muted">Progres pelunasan</span>
      <span class="fw-semibold text-success">{{ $iuranLunas }} / {{ $totalWarga }} warga ({{ $persenLunas }}%)</span>
    </div>
    <div class="progress mb-3" style="height: 8px; background-color: var(--light-green);">
      <div class="progress-bar" role="progressbar" style="width: {{ $persenLunas }}%; background-image: linear-gradient(90deg, var(--action-from), var(--action-to));" aria-valuenow="{{ $persenLunas }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
      <div class="input-group input-group-sm" style="max-width: 280px;">
        <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
        <input type="search" id="iuranSearch" class="form-control" placeholder="Cari nama warga...">
      </div>
      <small class="text-muted">Warga belum lunas ditampilkan lebih dulu</small>
    </div>

    <div class="table-responsive" style="max-height: 360px; overflow-y: auto;">
      <table class="table table-custom iuran-table mb-0 align-middle">
        <thead>
          <tr>
            <th>Warga</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Tanggal Bayar</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($statusIuran as $row)
            <tr data-iuran-row>
              <td>
                <div class="fw-medium">{{ $row->warga->nama_lengkap }}</div>
                <small class="text-muted">{{ $row->warga->nik }}</small>
              </td>
              <td>{{ $row->iuran ? 'Rp ' . number_format($row->iuran->jumlah, 0, ',', '.') : '-' }}</td>
              <td><span class="badge badge-soft-{{ $iuranBadgeMap[$row->status] ?? 'secondary' }}">{{ $row->status }}</span></td>
              <td>{{ $row->iuran?->tanggal_bayar?->format('d/m/Y') ?? '-' }}</td>
              <td class="text-center">
                @if ($row->status !== 'Lunas')
                  <form action="{{ route('iuran.lunas', $row->warga) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="periode" value="{{ $periodeIuran }}">
                    <button type="submit" class="btn btn-xs btn-primary-green" title="Tandai lunas"><i class="bi bi-check2"></i> Lunas</button>
                  </form>
                @else
                  <i class="bi bi-check-circle-fill text-success" title="Sudah lunas"></i>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-3">Belum ada data warga.</td>
            </tr>
          @endforelse
          <tr id="iuranSearchEmpty" class="d-none">
            <td colspan="5" class="text-center text-muted py-3">Warga tidak ditemukan.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-12 col-lg-8">
      <div class="card-custom p-3 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="font-heading fw-bold mb-0">Arus Kas RT (Pemasukan vs Pengeluaran)</h6>
          <span class="badge badge-soft-success">{{ now()->format('Y') }}</span>
        </div>
        <div style="height: 260px;">
          <canvas id="cashflowChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card-custom p-3 h-100">
        <h6 class="font-heading fw-bold mb-3">Demografi Warga</h6>
        <div style="height: 220px; position: relative;">
          <canvas id="genderChart"></canvas>
        </div>
        <div class="d-flex justify-content-center gap-3 mt-3 text-center" style="font-size: 0.8rem;">
          <div><i class="bi bi-circle-fill text-success me-1"></i>Laki-laki ({{ number_format($demografi['laki']) }})</div>
          <div><i class="bi bi-circle-fill text-warning me-1"></i>Perempuan ({{ number_format($demografi['perempuan']) }})</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-7">
      <div class="card-custom p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="font-heading fw-bold mb-0">Permohonan Surat Terbaru</h6>
          <a href="{{ route('surat.index') }}" class="text-primary-green text-decoration-none fw-semibold" style="font-size: 0.8rem;">Lihat Semua</a>
        </div>
        <div class="table-responsive">
          <table class="table table-custom mb-0">
            <thead>
              <tr>
                <th>Pemohon</th>
                <th>Jenis Surat</th>
                <th>Tanggal</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($suratTerbaru as $surat)
                <tr>
                  <td class="fw-medium">{{ $surat->warga?->nama_lengkap ?? '-' }}</td>
                  <td>{{ $surat->jenis_surat }}</td>
                  <td>{{ $surat->tanggal_pengajuan?->format('d/m/Y') ?? '-' }}</td>
                  <td><span class="badge badge-soft-{{ $suratBadgeMap[$surat->status] ?? 'info' }}">{{ $surat->status }}</span></td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-3">Belum ada permohonan surat.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-5">
      <div class="card-custom p-3">
        <h6 class="font-heading fw-bold mb-3">Agenda & Kegiatan Mendatang</h6>
        <div class="list-group list-group-flush border-0">
          @forelse ($agenda as $item)
            <a href="{{ route('pengumuman.show', $item) }}" class="list-group-item px-0 border-0 border-bottom border-color d-flex align-items-center gap-3 text-decoration-none">
              <div class="text-center p-2 rounded bg-soft-green text-primary-green fw-bold" style="min-width: 50px;">
                <div style="font-size: 0.7rem;" class="text-uppercase">{{ $item->tanggal_mulai->locale('id')->translatedFormat('M') }}</div>
                <div class="fs-5">{{ $item->tanggal_mulai->format('d') }}</div>
              </div>
              <div>
                <h6 class="mb-1 font-heading fw-semibold text-body" style="font-size: 0.9rem;">{{ $item->judul }}</h6>
                <small class="text-muted d-block">
                  <i class="bi bi-clock me-1"></i>{{ $item->waktu_mulai ?? '--:--' }} {{ $item->waktu_selesai ? '- ' . $item->waktu_selesai : '' }}
                  @if ($item->lokasi)
                    <i class="bi bi-geo-alt ms-2 me-1"></i>{{ $item->lokasi }}
                  @endif
                </small>
              </div>
            </a>
          @empty
            <p class="text-muted mb-0">Belum ada agenda mendatang.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection
