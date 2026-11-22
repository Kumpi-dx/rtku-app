(function () {
  var data = window.DASHBOARD_DATA || {
    chart: { labels: [], pemasukan: [], pengeluaran: [] },
    demografi: { laki: 0, perempuan: 0 }
  };

  var cashCanvas = document.getElementById('cashflowChart');
  if (cashCanvas) {
    new Chart(cashCanvas.getContext('2d'), {
      type: 'line',
      data: {
        labels: data.chart.labels,
        datasets: [
          {
            label: 'Pemasukan (Rp)',
            data: data.chart.pemasukan,
            borderColor: '#10B981',
            backgroundColor: 'rgba(16, 185, 129, 0.12)',
            fill: true,
            tension: 0.3
          },
          {
            label: 'Pengeluaran (Rp)',
            data: data.chart.pengeluaran,
            borderColor: '#F43F5E',
            backgroundColor: 'transparent',
            borderDash: [5, 5],
            tension: 0.3
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } },
        scales: {
          y: { grid: { borderDash: [2, 4] } },
          x: { grid: { display: false } }
        }
      }
    });
  }

  var iuranSearch = document.getElementById('iuranSearch');
  if (iuranSearch) {
    var iuranRows = document.querySelectorAll('[data-iuran-row]');
    var iuranEmpty = document.getElementById('iuranSearchEmpty');

    iuranSearch.addEventListener('input', function () {
      var keyword = iuranSearch.value.trim().toLowerCase();
      var shown = 0;

      iuranRows.forEach(function (row) {
        var match = row.textContent.toLowerCase().indexOf(keyword) !== -1;
        row.classList.toggle('d-none', !match);
        if (match) {
          shown++;
        }
      });

      if (iuranEmpty) {
        iuranEmpty.classList.toggle('d-none', shown !== 0);
      }
    });
  }

  var genderCanvas = document.getElementById('genderChart');
  if (genderCanvas) {
    new Chart(genderCanvas.getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: ['Laki-laki', 'Perempuan'],
        datasets: [{
          data: [data.demografi.laki, data.demografi.perempuan],
          backgroundColor: ['#10B981', '#F59E0B'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        cutout: '70%'
      }
    });
  }
})();
