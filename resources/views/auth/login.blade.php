@extends('layouts.auth')

@section('title', 'Login - Sistem Informasi Manajemen RT/RW')

@push('styles')
  <style>
    .auth-wrapper {
      position: relative;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
      overflow: hidden;
    }

    .auth-wrapper::before,
    .auth-wrapper::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      filter: blur(90px);
      opacity: 0.5;
      z-index: 0;
    }

    .auth-wrapper::before {
      width: 420px;
      height: 420px;
      background: radial-gradient(circle, rgba(52, 211, 153, 0.25) 0%, transparent 70%);
      top: -160px;
      right: -140px;
    }

    .auth-wrapper::after {
      width: 380px;
      height: 380px;
      background: radial-gradient(circle, rgba(34, 211, 238, 0.18) 0%, transparent 70%);
      bottom: -180px;
      left: -160px;
    }

    .auth-content {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 440px;
    }

    .auth-card {
      border: 1px solid var(--border-color);
      border-radius: var(--radius-lg);
      background: radial-gradient(120% 120% at 50% 0%, rgba(52, 211, 153, 0.12) 0%, transparent 55%), var(--card-bg);
      box-shadow: var(--shadow-subtle);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      overflow: hidden;
      position: relative;
    }

    .auth-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(52, 211, 153, 0.9), transparent);
    }

    .auth-card .card-body {
      padding: clamp(1.75rem, 4vw, 2.75rem);
    }

    .auth-logo {
      width: 56px;
      height: 56px;
      border-radius: var(--radius-md);
      background: linear-gradient(135deg, var(--primary-green), var(--action-to));
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      box-shadow: var(--shadow-glow);
      margin: 0 auto 1rem;
    }

    .auth-divider {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      color: var(--text-muted);
      font-size: 0.85rem;
      margin: 1.5rem 0;
    }

    .auth-divider::before,
    .auth-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--border-color), transparent);
    }

    .input-icon-group {
      position: relative;
    }

    .input-icon-group .form-control,
    .input-icon-group .form-select {
      padding-left: 2.6rem;
    }

    .input-icon-group .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      pointer-events: none;
      z-index: 5;
    }

    .input-icon-group .input-group-text-toggle {
      border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
      background-color: var(--card-bg);
      border: 1px solid var(--border-color);
      color: var(--text-muted);
      padding: 0.6rem 0.9rem;
    }

    .input-icon-group .input-group-text-toggle:hover {
      color: var(--primary-green);
      background-color: var(--soft-green);
      border-color: var(--card-hover-border);
    }
  </style>
@endpush

@push('scripts')
  <script>
    (function () {
      var form = document.getElementById('loginForm');
      var pass = document.getElementById('loginPassword');
      var toggle = document.getElementById('toggleLoginPass');
      var icon = toggle.querySelector('i');

      toggle.addEventListener('click', function () {
        if (pass.type === 'password') {
          pass.type = 'text';
          icon.classList.remove('bi-eye');
          icon.classList.add('bi-eye-slash');
        } else {
          pass.type = 'password';
          icon.classList.remove('bi-eye-slash');
          icon.classList.add('bi-eye');
        }
      });

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          showToast('Mohon lengkapi email/username dan kata sandi.');
          return;
        }
        form.submit();
      });
    })();
  </script>
@endpush

@section('content')
  <div class="auth-wrapper">
    <div class="auth-content">
      <div class="text-center mb-4">
        <div class="auth-logo">
          <i class="bi bi-house-heart"></i>
        </div>
        <h3 class="font-heading fw-bold mb-1">Selamat Datang Kembali</h3>
        <p class="text-muted mb-0">Masuk untuk mengelola administrasi RT 005 / RW 012 Sukamaju</p>
      </div>

      <div class="auth-card">
        <div class="card-body">
          <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
            @csrf

            @include('partials.auth-alerts')

            <div class="mb-3">
              <label for="loginEmail" class="form-label">Email atau Username</label>
              <div class="input-icon-group">
                <i class="bi bi-person input-icon"></i>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="loginEmail" name="email" value="{{ old('email') }}" placeholder="contoh: ketuart005 atau email@domain.com" autocomplete="username" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="loginPassword" class="form-label">Kata Sandi</label>
              <div class="input-group input-icon-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="loginPassword" name="password" placeholder="Masukkan kata sandi anda" autocomplete="current-password" required>
                <button class="btn btn-light input-group-text-toggle" type="button" id="toggleLoginPass" title="Tampilkan/Sembunyikan kata sandi">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4" style="font-size: 0.9rem;">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="rememberMe" name="remember" @checked(old('remember'))>
                <label class="form-check-label text-muted" for="rememberMe">
                  Ingat saya di perangkat ini
                </label>
              </div>
              <a href="#" class="text-primary-green text-decoration-none fw-semibold" onclick="showToast('Fitur lupa kata sandi belum tersedia (simulasi)'); return false;">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="btn btn-primary-green w-100 py-2">
              <i class="bi bi-box-arrow-in-right"></i>Masuk ke Dashboard
            </button>
          </form>

          <div class="auth-divider">atau</div>

          <div class="text-center" style="font-size: 0.95rem;">
            <span class="text-muted">Belum terdaftar sebagai warga/pengurus?</span>
            <div class="mt-2">
              <a href="{{ route('register') }}" class="btn btn-outline-light w-100 py-2">
                <i class="bi bi-person-plus"></i>Buat Akun Baru
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-4 text-muted" style="font-size: 0.85rem;">
        &copy; 2026 Sistem Informasi RT/RW Sukamaju â€¢ Dibangun untuk kemudahan administrasi lingkungan
      </div>
    </div>
  </div>
@endsection



