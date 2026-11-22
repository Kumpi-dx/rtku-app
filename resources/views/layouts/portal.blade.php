<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Portal Warga - SiRT-RW')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <style>
    .portal-body { background: var(--bg-main); color: var(--text-main); min-height: 100vh; padding-bottom: 96px; }
    .portal-container { max-width: 920px; margin: 0 auto; padding: 1rem; }
    .portal-topbar { position: sticky; top: 0; z-index: 1030; background: var(--topbar-bg); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border-color); }
    .portal-bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; z-index: 1030; display: flex; background: var(--card-bg); border-top: 1px solid var(--border-color); box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06); }
    .portal-bottom-nav a { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 2px; padding: 0.55rem 0 0.65rem; color: var(--text-muted); text-decoration: none; font-size: 0.72rem; font-weight: 500; }
    .portal-bottom-nav a i { font-size: 1.35rem; }
    .portal-bottom-nav a.active { color: var(--primary-green); font-weight: 700; }
    .portal-hero { background: linear-gradient(135deg, var(--action-from), var(--action-to)); color: #ffffff; border-radius: var(--radius-lg); padding: 1.25rem; box-shadow: var(--shadow-glow); }
    .portal-hero small, .portal-hero .text-muted { color: rgba(255, 255, 255, 0.85) !important; }
    .portal-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.75rem; }
    .portal-tile { display: flex; align-items: center; gap: 0.75rem; padding: 0.9rem; border-radius: var(--radius-md); background: var(--card-bg); border: 1px solid var(--border-color); text-decoration: none; color: inherit; box-shadow: var(--shadow-card); transition: var(--transition-base); }
    .portal-tile:hover { border-color: var(--card-hover-border); transform: translateY(-2px); color: inherit; }
    .portal-tile .tile-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; background: var(--soft-green); color: var(--primary-green); flex-shrink: 0; }
    .portal-tile .tile-title { font-weight: 600; font-size: 0.9rem; line-height: 1.1; }
    .portal-tile .tile-sub { font-size: 0.72rem; color: var(--text-muted); }
    .portal-section-title { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin: 1.25rem 0 0.5rem; }
    .portal-list-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.8rem; border-radius: var(--radius-md); background: var(--card-bg); border: 1px solid var(--border-color); text-decoration: none; color: inherit; margin-bottom: 0.5rem; transition: var(--transition-base); }
    .portal-list-item:hover { border-color: var(--card-hover-border); color: inherit; }
    .portal-date-badge { min-width: 48px; text-align: center; padding: 0.35rem; border-radius: 10px; background: var(--soft-green); color: var(--primary-green); font-weight: 700; }
  </style>

  <script src="{{ asset('assets/js/theme-init.js') }}"></script>
</head>
<body class="portal-body">
  @php
    $portalUser = auth()->user();
  @endphp

  <header class="portal-topbar">
    <div class="portal-container d-flex align-items-center justify-content-between py-2">
      <a href="{{ route('portal.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
        <div class="bg-soft-green text-primary-green rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1.25rem;">
          <i class="bi bi-house-heart"></i>
        </div>
        <div>
          <div class="fw-bold text-primary-green font-heading" style="line-height: 1.1;">SiRT-RW</div>
          <small class="text-muted" style="font-size: 0.7rem;">Portal Warga</small>
        </div>
      </a>

      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-light rounded-circle p-2" id="themeToggleBtn" title="Mode Tampilan">
          <i class="bi bi-sun" id="themeIcon"></i>
        </button>
        <div class="dropdown">
          <button class="btn btn-light rounded-circle p-2" data-bs-toggle="dropdown" title="Akun">
            <i class="bi bi-person-circle"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li><h6 class="dropdown-header">{{ $portalUser?->name ?? 'Warga' }}</h6></li>
            <li><a class="dropdown-item" href="{{ route('portal.profil') }}"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
            <li><a class="dropdown-item" href="{{ route('portal.agenda') }}"><i class="bi bi-calendar-event me-2"></i>Agenda</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" onclick="logoutNow(); return false;"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <main class="portal-container">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.875rem;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger" role="alert" style="font-size: 0.85rem;">
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>

  <nav class="portal-bottom-nav">
    <a href="{{ route('portal.index') }}" class="{{ request()->routeIs('portal.index') ? 'active' : '' }}">
      <i class="bi bi-house-door-fill"></i><span>Beranda</span>
    </a>
    <a href="{{ route('portal.iuran') }}" class="{{ request()->routeIs('portal.iuran') ? 'active' : '' }}">
      <i class="bi bi-wallet2"></i><span>Iuran</span>
    </a>
    <a href="{{ route('portal.surat') }}" class="{{ request()->routeIs('portal.surat*') ? 'active' : '' }}">
      <i class="bi bi-file-earmark-text-fill"></i><span>Surat</span>
    </a>
    <a href="{{ route('portal.pengumuman') }}" class="{{ request()->routeIs('portal.pengumuman*') || request()->routeIs('portal.agenda') ? 'active' : '' }}">
      <i class="bi bi-megaphone-fill"></i><span>Info</span>
    </a>
    <a href="{{ route('portal.profil') }}" class="{{ request()->routeIs('portal.profil*') ? 'active' : '' }}">
      <i class="bi bi-person-circle"></i><span>Profil</span>
    </a>
  </nav>

  <script>
    window.SIRT = window.SIRT || { routes: { login: "{{ route('login') }}", logout: "{{ route('logout') }}" } };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>
