function handleNewSurat(e) {
  e.preventDefault();
  showToast('Permohonan surat berhasil dikirim!');
  bootstrap.Modal.getOrCreateInstance(document.getElementById('newSuratModal')).hide();
}

function openSuratPreview(nama, jenis, nomor, keperluan) {
  document.getElementById('prevNama').innerText = nama;
  document.getElementById('prevJenis').innerText = jenis.toUpperCase();
  document.getElementById('prevNomor').innerText = nomor;
  document.getElementById('prevKeperluan').innerText = keperluan;

  bootstrap.Modal.getOrCreateInstance(document.getElementById('previewSuratModal')).show();
}
