@extends('layouts.app')

@section('title', 'Manajemen Pengguna - Sistem Informasi Manajemen RT/RW')
@section('page', 'pengguna')

@section('content')
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h4 class="font-heading fw-bold mb-1">Manajemen Pengguna & Hak Akses</h4>
      <p class="text-muted mb-0" style="font-size: 0.875rem;">Pengaturan akun pengurus RT dan akses portal warga.</p>
    </div>
    <a href="{{ route('pengguna.create') }}" class="btn btn-sm btn-primary-green"><i class="bi bi-person-plus-fill"></i>Tambah Pengguna</a>
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
            <th>Pengguna</th>
            <th>Email</th>
            <th>Terdaftar</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $user)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="bg-soft-green text-primary-green rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px; font-weight: 700;">
                    {{ strtoupper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}
                  </div>
                  <span class="fw-medium">{{ $user->name }}</span>
                </div>
              </td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at?->format('d M Y') ?? '-' }}</td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                  <a href="{{ route('pengguna.edit', $user) }}" class="btn btn-xs btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                  @unless (auth()->id() === $user->id)
                    <form action="{{ route('pengguna.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-xs btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                    </form>
                  @endunless
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-muted py-4">Belum ada pengguna.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-3 border-top border-color d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.85rem;">
      <span class="text-muted">Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna</span>
      {{ $users->links() }}
    </div>
  </div>
@endsection
