<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Sistem Informasi Manajemen RT/RW')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  @stack('styles')

  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <script>
    window.SIRT = {
      routes: {
        dashboard: "{{ route('dashboard') }}",
        warga: "{{ route('warga.index') }}",
        surat: "{{ route('surat.index') }}",
        keuangan: "{{ route('keuangan.index') }}",
        pengumuman: "{{ route('pengumuman.index') }}",
        pengguna: "{{ route('pengguna.index') }}",
        login: "{{ route('login') }}",
        logout: "{{ route('logout') }}"
      },
      user: {
        name: "{{ auth()->user()?->name ?? 'H. Bambang S.' }}",
        role: "{{ auth()->user()?->name ? 'Pengurus RT' : 'Ketua RT 005' }}"
      }
    };
  </script>

  <script src="{{ asset('assets/js/theme-init.js') }}"></script>
</head>
<body data-page="@yield('page', 'dashboard')">
  <div id="wrapper">
    <aside id="sidebar"></aside>

    <div id="content-wrapper">
      <header class="top-navbar" id="topbar"></header>

      <main class="p-3 p-md-4 flex-grow-1">
        <div class="page-view">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  @stack('modals')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/layout.js') }}"></script>
  <script src="{{ asset('assets/js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>
