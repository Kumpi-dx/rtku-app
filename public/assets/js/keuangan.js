function handleAddFinance(e, type) {
  e.preventDefault();
  const isMasuk = type === 'Pemasukan';
  const ket = document.getElementById(isMasuk ? 'finKetMasuk' : 'finKetKeluar').value;
  const nom = document.getElementById(isMasuk ? 'finNomMasuk' : 'finNomKeluar').value;
  const kat = document.getElementById(isMasuk ? 'finKatMasuk' : 'finKatKeluar').value;

  const tbody = document.getElementById('financeTableBody');
  const newRow = `
    <tr>
      <td>31/10/2026</td>
      <td>${kat}</td>
      <td>${ket}</td>
      <td class="fw-bold ${isMasuk ? 'text-success' : 'text-danger'}">${isMasuk ? '+' : '-'}Rp ${parseInt(nom).toLocaleString('id-ID')}</td>
      <td><span class="badge ${isMasuk ? 'badge-soft-success' : 'badge-soft-danger'}">${type}</span></td>
    </tr>
  `;
  tbody.insertAdjacentHTML('afterbegin', newRow);

  const modalId = isMasuk ? 'pemasukanModal' : 'pengeluaranModal';
  bootstrap.Modal.getOrCreateInstance(document.getElementById(modalId)).hide();
  showToast(type + ' sebesar Rp ' + parseInt(nom).toLocaleString('id-ID') + ' dicatat.');
}
