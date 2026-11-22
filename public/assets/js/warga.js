function filterWargaTable() {
  const search = document.getElementById('searchWargaInput').value.toLowerCase();
  const gender = document.getElementById('filterGender').value;
  const rows = document.querySelectorAll('#wargaTableBody tr');

  rows.forEach(function (row) {
    const text = row.innerText.toLowerCase();
    const rowGender = row.cells[2].innerText;
    const matchesSearch = text.includes(search);
    const matchesGender = gender === '' || rowGender === gender;

    row.style.display = matchesSearch && matchesGender ? '' : 'none';
  });
}

function deleteRow(btn) {
  if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
    btn.closest('tr').remove();
    showToast('Data berhasil dihapus.');
  }
}

function viewProfile(nama, nik, alamat, pekerjaan) {
  document.getElementById('profName').innerText = nama;
  document.getElementById('profNik').innerText = 'NIK: ' + nik;
  document.getElementById('profAddress').innerText = alamat;
  document.getElementById('profJob').innerText = pekerjaan;

  bootstrap.Modal.getOrCreateInstance(document.getElementById('profileModal')).show();
}

function handleAddWarga(e) {
  e.preventDefault();
  const nama = document.getElementById('newNama').value;
  const gender = document.getElementById('newGender').value;
  const telp = document.getElementById('newTelp').value || '0812-XXXX-XXXX';
  const job = document.getElementById('newJob').value || 'Wiraswasta';
  const domisili = document.getElementById('newDomisili').value;

  const tbody = document.getElementById('wargaTableBody');
  const newRow = `
    <tr>
      <td class="fw-medium">32750${Math.floor(1000000000 + Math.random() * 9000000000)}</td>
      <td>${nama}</td>
      <td>${gender}</td>
      <td>${telp}</td>
      <td>${job}</td>
      <td><span class="badge ${domisili === 'Tetap' ? 'badge-soft-success' : 'badge-soft-info'}">${domisili}</span></td>
      <td class="text-center">
        <button class="btn btn-xs btn-light" onclick="viewProfile('${nama}', 'NIK Simulasikan', 'Jl. Sukamaju', '${job}')" title="Detail"><i class="bi bi-eye"></i></button>
        <button class="btn btn-xs btn-light" onclick="showToast('Edit data warga')" title="Edit"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-xs btn-light text-danger" onclick="deleteRow(this)" title="Hapus"><i class="bi bi-trash"></i></button>
      </td>
    </tr>
  `;
  tbody.insertAdjacentHTML('afterbegin', newRow);

  bootstrap.Modal.getOrCreateInstance(document.getElementById('addWargaModal')).hide();
  showToast('Data warga ' + nama + ' berhasil ditambahkan!');
  document.getElementById('addWargaForm').reset();
}

function exportDataSimulated(type) {
  showToast('Mengeksport data warga ke format ' + type + '...');
}
