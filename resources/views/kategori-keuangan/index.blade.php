@extends('layouts.app')

@section('title', 'Kategori Keuangan - Sistem Informasi Manajemen RT/RW')
@section('page', 'keuangan')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Kategori Keuangan</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Kelola kategori pemasukan dan pengeluaran kas RT.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left"></i>Kas</a>
      <a href="{{ route('kategori-keuangan.create') }}" class="btn btn-sm btn-primary-green"><i class="bi bi-plus-lg"></i>Tambah Kategori</a>
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

  <div class="card-custom">
    <div class="table-responsive">
      <table class="table table-custom mb-0">
        <thead>
          <tr>
            <th>Nama Kategori</th>
            <th>Tipe</th>
            <th>Keterangan</th>
            <th>Jumlah Transaksi</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($kategoris as $kategori)
            <tr>
              <td class="fw-medium">{{ $kategori->nama }}</td>
              <td><span class="badge badge-soft-{{ $kategori->tipe === 'pemasukan' ? 'success' : 'danger' }}">{{ ucfirst($kategori->tipe) }}</span></td>
              <td>{{ $kategori->keterangan ?? '-' }}</td>
              <td>{{ $kategori->keuangans_count }}</td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  <a href="{{ route('kategori-keuangan.edit', $kategori) }}" class="btn btn-xs btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                  <form action="{{ route('kategori-keuangan.destroy', $kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori {{ $kategori->nama }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">Belum ada kategori keuangan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3 border-top border-color" style="font-size: 0.85rem;">{{ $kategoris->links() }}</div>
  </div>
@endsection
