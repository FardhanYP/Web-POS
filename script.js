document.getElementById('form-login').addEventListener('submit', function(e) {
  e.preventDefault(); // Biar halaman gak ke-refresh

  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  const pesanError = document.getElementById('pesan-error');
  const tombolLogin = document.getElementById('tombol-login');

  // Ubah teks tombol biar kasir tau sistem lagi proses
  tombolLogin.textContent = 'Memeriksa...';
  pesanError.textContent = '';

  // Kirim data ke api.php
  fetch('api.php?action=login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ username: username, password: password })
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      // Kalau sukses, simpan nama kasir dan pindah ke halaman kasir
      localStorage.setItem('nama_kasir', data.nama);
      window.location.href = 'kasir.html';
    } else {
      // Kalau gagal, munculin pesan ramah (bukan error sistem)
      pesanError.textContent = data.pesan;
      tombolLogin.textContent = 'Masuk ke Kasir';
    }
  })
  .catch(error => {
    pesanError.textContent = 'Gagal terhubung ke server. Cek XAMPP kamu.';
    tombolLogin.textContent = 'Masuk ke Kasir';
    console.error('Error:', error);
  });
});
