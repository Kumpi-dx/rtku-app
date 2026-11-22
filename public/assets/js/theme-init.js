(function () {
  try {
    var saved = localStorage.getItem('sirt-theme');
    document.documentElement.setAttribute('data-bs-theme', saved === 'light' ? 'light' : 'dark');
  } catch (error) {
    document.documentElement.setAttribute('data-bs-theme', 'dark');
  }
})();
