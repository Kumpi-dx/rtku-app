(function () {
  var page = document.body.dataset.page || 'dashboard';
  function sirtRoute(key, fallback) {
    return (window.SIRT && window.SIRT.routes && window.SIRT.routes[key]) ? window.SIRT.routes[key] : fallback;
  }
  var titles = {
    dashboard: 'Dashboard',
    warga: 'Data Warga',
    surat: 'Administrasi Surat',
    keuangan: 'Kas & Iuran',
    pengumuman: 'Pengumuman & Kegiatan',
    pengguna: 'Manajemen Pengguna'
  };
  var title = titles[page] || 'Halaman';

  var sidebar = document.getElementById('sidebar');
  if (sidebar) {
    sidebar.innerHTML = `
      <div class="sidebar-header border-bottom border-color">
        <a href="index.html" class="sidebar-brand">
          <div class="brand-logo"><i class="bi bi-house-heart"></i></div>
          <div class="sidebar-text">
            <h6 class="mb-0 font-heading fw-bold text-primary-green">SiRT-RW</h6>
            <small class="text-muted" style="font-size: 0.725rem;">RT 005 / RW 012 Sukamaju</small>
          </div>
        </a>
      </div>

      <div class="sidebar-menu">
        <div class="menu-category">MAIN</div>
        <a class="nav-link-custom" data-nav="dashboard" href="${sirtRoute('dashboard', 'index.html')}">
          <i class="bi bi-grid-1x2-fill"></i>
          <span class="sidebar-text">Dashboard</span>
        </a>

        <div class="menu-category">DATA WARGA</div>
        <a class="nav-link-custom" data-nav="warga" href="${sirtRoute('warga', 'warga.html')}">
          <i class="bi bi-people-fill"></i>
          <span class="sidebar-text">Warga</span>
        </a>
        <a class="nav-link-custom" href="${sirtRoute('warga', 'warga.html')}">
          <i class="bi bi-card-heading"></i>
          <span class="sidebar-text">Kepala Keluarga</span>
        </a>

        <div class="menu-category">ADMINISTRASI</div>
        <a class="nav-link-custom" data-nav="surat" href="${sirtRoute('surat', 'surat.html')}">
          <i class="bi bi-file-earmark-text-fill"></i>
          <span class="sidebar-text">Permohonan Surat</span>
          <span class="badge badge-soft-warning ms-auto sidebar-badge">3</span>
        </a>
        <a class="nav-link-custom" href="${sirtRoute('surat', 'surat.html')}">
          <i class="bi bi-archive-fill"></i>
          <span class="sidebar-text">Arsip Surat</span>
        </a>

        <div class="menu-category">KEUANGAN</div>
        <a class="nav-link-custom" data-nav="keuangan" href="${sirtRoute('keuangan', 'keuangan.html')}">
          <i class="bi bi-wallet2"></i>
          <span class="sidebar-text">Kas &amp; Iuran RT</span>
        </a>

        <div class="menu-category">INFORMASI</div>
        <a class="nav-link-custom" data-nav="pengumuman" href="${sirtRoute('pengumuman', 'pengumuman.html')}">
          <i class="bi bi-megaphone-fill"></i>
          <span class="sidebar-text">Pengumuman</span>
        </a>

        <div class="menu-category">PENGATURAN</div>
        <a class="nav-link-custom" data-nav="pengguna" href="${sirtRoute('pengguna', 'pengguna.html')}">
          <i class="bi bi-shield-lock-fill"></i>
          <span class="sidebar-text">Manajemen Pengguna</span>
        </a>
      </div>
    `;

    var active = sidebar.querySelector('[data-nav="' + page + '"]');
    if (active) {
      active.classList.add('active');
    }
  }

  var topbar = document.getElementById('topbar');
  if (topbar) {
    topbar.innerHTML = `
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-light d-none d-lg-inline-flex" id="toggleSidebarBtn" title="Buka/Tutup Sidebar">
          <i class="bi bi-list fs-5"></i>
        </button>
        <button class="btn btn-sm btn-light d-lg-none" id="toggleMobileSidebarBtn" title="Menu">
          <i class="bi bi-list fs-5"></i>
        </button>

        <nav aria-label="breadcrumb" class="d-none d-sm-block">
          <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
            <li class="breadcrumb-item"><a href="index.html" class="text-decoration-none text-muted">Sistem RT/RW</a></li>
            <li class="breadcrumb-item active fw-medium text-primary-green" id="breadcrumbCurrent">${title}</li>
          </ol>
        </nav>
      </div>

      <div class="d-flex align-items-center gap-3">
        <div class="search-bar d-none d-md-block">
          <i class="bi bi-search"></i>
          <input type="text" class="form-control" placeholder="Cari NIK, Warga, Surat...">
        </div>

        <button class="btn btn-light rounded-circle p-2" id="themeToggleBtn" title="Ubah Mode Tampilan">
          <i class="bi bi-sun" id="themeIcon"></i>
        </button>

        <div class="dropdown">
          <button class="btn btn-light rounded-circle p-2 position-relative" data-bs-toggle="dropdown" title="Notifikasi">
            <i class="bi bi-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
          </button>
          <div class="dropdown-menu dropdown-menu-end shadow-sm border-color p-2" style="width: 300px;">
            <h6 class="dropdown-header font-heading fw-bold">Notifikasi Terbaru</h6>
            <div class="list-group list-group-flush" style="font-size: 0.825rem;">
              <a href="#" class="list-group-item list-group-item-action border-0 rounded p-2">
                <div class="fw-semibold">Permohonan Surat Baru</div>
                <small class="text-muted">Budi Santoso mengajukan SK Domisili</small>
              </a>
              <a href="#" class="list-group-item list-group-item-action border-0 rounded p-2">
                <div class="fw-semibold">Pembayaran Iuran Kas</div>
                <small class="text-muted">Ahmad Dahlan membayar Rp 100.000</small>
              </a>
            </div>
          </div>
        </div>

        <div class="d-none d-xl-block text-end ps-2 border-start border-color">
          <div class="fw-semibold" style="font-size: 0.825rem;" id="currentDateText">Sabtu, 31 Okt 2026</div>
          <small class="text-muted" style="font-size: 0.725rem;">Wilayah RT 005 / RW 012</small>
        </div>

        <div class="dropdown ps-2 border-start border-color">
          <button class="btn btn-light topbar-user d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" title="Akun Pengguna">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" class="rounded-circle topbar-user-avatar" width="34" height="34" alt="H. Bambang S.">
            <span class="d-none d-md-block text-start lh-sm">
              <span class="d-block fw-semibold" style="font-size: 0.825rem;">${window.SIRT.user ? window.SIRT.user.name : 'H. Bambang S.'}</span>
              <small class="text-muted d-block" style="font-size: 0.7rem;">${window.SIRT.user ? window.SIRT.user.role : 'Ketua RT 005'}</small>
            </span>
            <i class="bi bi-chevron-down d-none d-md-block text-muted" style="font-size: 0.7rem;"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-color">
            <li><h6 class="dropdown-header">Masuk sebagai</h6></li>
            <li><span class="dropdown-item-text small">${window.SIRT.user ? window.SIRT.user.name : 'H. Bambang S.'}<br><span class="text-muted">${window.SIRT.user ? window.SIRT.user.role : 'Ketua RT 005'}</span></span></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil Saya</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" onclick="logoutNow(); return false;"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
          </ul>
        </div>
      </div>
    `;
  }

  if (!document.getElementById('liveToast')) {
    document.body.insertAdjacentHTML('beforeend', `
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast align-items-center text-white bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body" id="toastMessage">
              Aksi berhasil dilakukan.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
          </div>
        </div>
      </div>
    `);
  }
})();


