async function logoutNow() {
  const logoutUrl = (window.SIRT && window.SIRT.routes && window.SIRT.routes.logout) || '/logout';
  const loginUrl = (window.SIRT && window.SIRT.routes && window.SIRT.routes.login) || '/login';
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

  await fetch(logoutUrl, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrfToken,
      'X-Requested-With': 'XMLHttpRequest',
    },
  });

  window.location.href = loginUrl;
}
function showToast(message) {
  const toastEl = document.getElementById('liveToast');
  if (!toastEl) return;
  document.getElementById('toastMessage').innerText = message;
  bootstrap.Toast.getOrCreateInstance(toastEl).show();
}

function syncThemeIcon() {
  const theme = document.documentElement.getAttribute('data-bs-theme');
  const icon = document.getElementById('themeIcon');
  if (icon) {
    icon.className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
  }
}

function setCurrentDate() {
  const el = document.getElementById('currentDateText');
  if (!el) return;
  try {
    el.textContent = new Intl.DateTimeFormat('id-ID', {
      weekday: 'long',
      day: '2-digit',
      month: 'short',
      year: 'numeric'
    }).format(new Date());
  } catch (error) {
    el.textContent = 'Sabtu, 31 Okt 2026';
  }
}

(function bindLayoutEvents() {
  const desktopToggle = document.getElementById('toggleSidebarBtn');
  if (desktopToggle) {
    desktopToggle.addEventListener('click', function () {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('content-wrapper').classList.toggle('expanded');
    });
  }

  const mobileToggle = document.getElementById('toggleMobileSidebarBtn');
  if (mobileToggle) {
    mobileToggle.addEventListener('click', function () {
      document.getElementById('sidebar').classList.toggle('show-mobile');
    });
  }

  const themeToggle = document.getElementById('themeToggleBtn');
  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      const current = document.documentElement.getAttribute('data-bs-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-bs-theme', next);
      try {
        localStorage.setItem('sirt-theme', next);
      } catch (error) {}
      syncThemeIcon();
    });
  }

  syncThemeIcon();
  setCurrentDate();
})();

