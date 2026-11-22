@extends('layouts.auth')

@section('title', 'Registrasi - Sistem Informasi Manajemen RT/RW')

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
      width: 460px;
      height: 460px;
      background: radial-gradient(circle, rgba(52, 211, 153, 0.24) 0%, transparent 70%);
      top: -200px;
      right: -160px;
    }

    .auth-wrapper::after {
      width: 420px;
      height: 420px;
      background: radial-gradient(circle, rgba(139, 92, 246, 0.16) 0%, transparent 70%);
      bottom: -220px;
      left: -180px;
    }

    .auth-content {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 580px;
    }

    .auth-card {
      border: 1px solid var(--border-color);
      border-radius: var(--radius-lg);
      background: radial-gradient(140% 140% at 50% 0%, rgba(52, 211, 153, 0.14) 0%, transparent 55%), var(--card-bg);
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
      padding: clamp(1.75rem, 5vw, 3rem);
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

    .section-title {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .section-title::after {
      content: '';
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, var(--border-color), transparent);
    }
  </style>
@endpush

@push('scripts')
  <script>
    (function () {
      var form = document.getElementById('registerForm');
      var pass1 = document.getElementById('regPassword');
      var pass2 = document.getElementById('regPasswordConfirm');
      var toggle1 = document.getElementById('toggleRegPass1');
      var toggle2 = document.getElementById('toggleRegPass2');
      var icon1 = toggle1.querySelector('i');
      var icon2 = toggle2.querySelector('i');
      var nik = document.getElementById('regNIK');

      function toggle(input, icon) {
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.remove('bi-eye');
          icon.classList.add('bi-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.remove('bi-eye-slash');
          icon.classList.add('bi-eye');
        }
      }

      toggle1.addEventListener('click', function () { toggle(pass1, icon1); });
      toggle2.addEventListener('click', function () { toggle(pass2, icon2); });

      nik.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
      });

      pass2.addEventListener('input', function () {
        if (pass2.value === '') {
          pass2.classList.remove('is-invalid');
          return;
        }
        if (pass2.value !== pass1.value) {
          pass2.classList.add('is-invalid');
        } else {
          pass2.classList.remove('is-invalid');
        }
      });

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (pass2.value !== pass1.value) {
          pass2.classList.add('is-invalid');
        }
        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          showToast('Mohon periksa kembali seluruh data pendaftaran.');
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
        <h3 class="font-heading fw-bold mb-1">Buat Akun Baru</h3>
        <p class="text-muted mb-0">Daftarkan diri anda untuk mengakses layanan administrasi RT 005 / RW 012 Sukamaju</p>
      </div>

      <div class="auth-card">
        <div class="card-body">
          <form id="registerForm" action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            @include('partials.auth-alerts')

            <div class="section-title text-muted">
              <i class="bi bi-person-vcard text-primary-green"></i>
              <span>Data Pribadi</span>
            </div>

            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label for="regNama" class="form-label">Nama Lengkap</label>
                <div class="input-icon-group">
                  <i class="bi bi-person input-icon"></i>
                  <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="regNama" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Sesuai KTP" autocomplete="name" required>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label for="regNIK" class="form-label">NIK</label>
                <div class="input-icon-group">
                  <i class="bi bi-card-text input-icon"></i>
                  <input type="text" class="form-control @error('nik') is-invalid @enderror" id="regNIK" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" inputmode="numeric" pattern="[0-9]{16}" maxlength="16" required>
                </div>
                <div class="form-text" style="font-size: 0.75rem;">Wajib 16 digit angka sesuai identitas.</div>
              </div>
              <div class="col-12 col-md-6">
                <label for="regEmail" class="form-label">Email Aktif</label>
                <div class="input-icon-group">
                  <i class="bi bi-envelope input-icon"></i>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="regEmail" name="email" value="{{ old('email') }}" placeholder="nama@contoh.com" autocomplete="email" required>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label for="regTelp" class="form-label">No. Telepon / WA</label>
                <div class="input-icon-group">
                  <i class="bi bi-whatsapp input-icon"></i>
                  <input type="tel" class="form-control @error('no_telp') is-invalid @enderror" id="regTelp" name="no_telp" value="{{ old('no_telp') }}" placeholder="08xxxxxxxxxx" inputmode="tel" autocomplete="tel" required>
                </div>
              </div>
            </div>

            <div class="section-title text-muted mt-4">
              <i class="bi bi-shield-lock text-primary-green"></i>
              <span>Keamanan Akun</span>
            </div>

            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label for="regPassword" class="form-label">Kata Sandi</label>
                <div class="input-group input-icon-group">
                  <i class="bi bi-lock input-icon"></i>
                  <input type="password" class="form-control" id="regPassword" name="password" placeholder="Minimal 8 karakter" minlength="8" required>
                  <button class="btn btn-light input-group-text-toggle" type="button" id="toggleRegPass1">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label for="regPasswordConfirm" class="form-label">Konfirmasi Kata Sandi</label>
                <div class="input-group input-icon-group">
                  <i class="bi bi-lock-fill input-icon"></i>
                  <input type="password" class="form-control" id="regPasswordConfirm" name="password_confirmation" placeholder="Ulangi kata sandi" minlength="8" required>
                  <button class="btn btn-light input-group-text-toggle" type="button" id="toggleRegPass2">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
                <div class="invalid-feedback">Kata sandi tidak sama.</div>
              </div>
            </div>

            <div class="section-title text-muted mt-4">
              <i class="bi bi-people text-primary-green"></i>
              <span>Peran & Persetujuan</span>
            </div>

            <div class="row g-3">
              <div class="col-12">
                <div class="p-3 rounded-3 border border-color" style="background: var(--soft-green); font-size: 0.85rem;">
                  <i class="bi bi-info-circle me-1 text-primary-green"></i>
                  Pendaftaran ini membuat akun <strong>Warga</strong>. Akun pengurus hanya dapat dibuat oleh Ketua RT melalui menu Pengguna.
                </div>
              </div>
              <div class="col-12">
                <div class="p-3 rounded-3 border border-color" style="background: var(--soft-green);">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="agreeTerms" required>
                    <label class="form-check-label" for="agreeTerms" style="font-size: 0.9rem;">
                      Saya telah membaca dan menyetujui <a href="#" class="text-primary-green text-decoration-none fw-semibold" onclick="showToast('Ketentuan penggunaan belum tersedia (simulasi)'); return false;">Ketentuan Penggunaan</a>, <a href="#" class="text-primary-green text-decoration-none fw-semibold" onclick="showToast('Kebijakan privasi belum tersedia (simulasi)'); return false;">Kebijakan Privasi</a>, serta bersedia mematuhi tata tertib lingkungan RT 005 / RW 012 Sukamaju.
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary-green w-100 py-2 mt-4">
              <i class="bi bi-person-check"></i>Kirim Pendaftaran
            </button>
          </form>

          <div class="auth-divider">atau</div>

          <div class="text-center" style="font-size: 0.95rem;">
            <span class="text-muted">Sudah memiliki akun?</span>
            <div class="mt-2">
              <a href="{{ route('login') }}" class="btn btn-outline-light w-100 py-2">
                <i class="bi bi-box-arrow-in-right"></i>Masuk ke Akun
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-4 text-muted" style="font-size: 0.85rem;">
        &copy; 2026 Sistem Informasi RT/RW Sukamaju â€¢ Data yang anda kirim akan digunakan untuk keperluan administrasi lingkungan
      </div>
    </div>
  </div>
@endsection



