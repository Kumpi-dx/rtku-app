@extends('layouts.app')

@section('title', 'Kas & Iuran - Sistem Informasi Manajemen RT/RW')
@section('page', 'keuangan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Manajemen Kas & Iuran RT</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Pencatatan transparan uang masuk dan pengeluaran operasional.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('kategori-keuangan.index') }}" class="btn btn-sm btn-light">
        <i class="bi bi-tags"></i>Kategori
      </a>
      <a href="{{ route('iuran.index') }}" class="btn btn-sm btn-outline-success">
        <i class="bi bi-receipt"></i>Iuran Warga
      </a>
      <a href="{{ route('keuangan.create', ['tipe' => 'pengeluaran']) }}" class="btn btn-sm btn-outline-danger">
        <i class="bi bi-dash-circle"></i>Catat Pengeluaran
      </a>
      <a href="{{ route('keuangan.create', ['tipe' => 'pemasukan']) }}" class="btn btn-sm btn-primary-green">
        <i class="bi bi-plus-circle"></i>Catat Pemasukan
      </a>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.875rem;">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 0.875rem;">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row g-3 mb-3">
    <div class="col-12 col-md-3">
      <div class="card-custom p-3 border-start border-4 border-success">
        <small class="text-muted d-block mb-1">Saldo Kas RT Saat Ini</small>
        <h4 class="font-heading fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card-custom p-3 border-start border-4 border-primary">
        <small class="text-muted d-block mb-1">Pemasukan Bulan Ini</small>
        <h4 class="font-heading fw-bold mb-0 text-success">+Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</h4>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card-custom p-3 border-start border-4 border-danger">
        <small class="text-muted d-block mb-1">Pengeluaran Bulan Ini</small>
        <h4 class="font-heading fw-bold mb-0 text-danger">-Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</h4>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card-custom p-3 border-start border-4 border-warning">
        <small class="text-muted d-block mb-1">Tunggakan Iuran</small>
        <h4 class="font-heading fw-bold mb-0 text-warning">Rp {{ number_format(\App\Models\Iuran::where('status', '!=', 'Lunas')->sum('jumlah'), 0, ',', '.') }}</h4>
      </div>
    </div>
  </div>

  <div class="card-custom p-3 mb-3">
    <form method="GET" action="{{ route('keuangan.index') }}" class="row g-2">
      <div class="col-12 col-md-3">
        <select name="tipe" class="form-select form-select-sm">
          <option value="">Semua Tipe</option>
          <option value="pemasukan" @selected(request('tipe') === 'pemasukan')>Pemasukan</option>
          <option value="pengeluaran" @selected(request('tipe') === 'pengeluaran')>Pengeluaran</option>
        </select>
      </div>
      <div class="col-12 col-md-4">
        <select name="kategori_keuangan_id" class="form-select form-select-sm">
          <option value="">Semua Kategori</option>
          @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}" @selected((int) request('kategori_keuangan_id') === $kategori->id)>{{ $kategori->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-8 col-md-3">
        <input type="month" name="bulan" value="{{ request('bulan') }}" class="form-control form-control-sm">
      </div>
      <div class="col-4 col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-primary-green w-100"><i class="bi bi-search"></i></button>
        <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-light"><i class="bi bi-x-lg"></i></a>
      </div>
    </form>
  </div>

  <div class="card-custom">
    <div class="p-3 border-bottom border-color fw-bold font-heading">Riwayat Transaksi</div>
    <div class="table-responsive">
      <table class="table table-custom mb-0">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Keterangan</th>
            <th>Nominal</th>
            <th>Tipe</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($keuangans as $keuangan)
            <tr>
              <td>{{ $keuangan->tanggal?->format('d/m/Y') ?? '-' }}</td>
              <td>{{ $keuangan->kategoriKeuangan?->nama ?? '-' }}</td>
              <td>{{ $keuangan->keterangan }}</td>
              <td class="fw-bold {{ $keuangan->tipe === 'pemasukan' ? 'text-success' : 'text-danger' }}">
                {{ $keuangan->tipe === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($keuangan->nominal, 0, ',', '.') }}
              </td>
              <td><span class="badge badge-soft-{{ $keuangan->tipe === 'pemasukan' ? 'success' : 'danger' }}">{{ ucfirst($keuangan->tipe) }}</span></td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  <a href="{{ route('keuangan.edit', $keuangan) }}" class="btn btn-xs btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                  <form action="{{ route('keuangan.destroy', $keuangan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi kas.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3 border-top border-color d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.85rem;">
      <span class="text-muted">Menampilkan {{ $keuangans->firstItem() ?? 0 }}-{{ $keuangans->lastItem() ?? 0 }} dari {{ $keuangans->total() }} transaksi</span>
      {{ $keuangans->links() }}
    </div>
  </div>
@endsection
