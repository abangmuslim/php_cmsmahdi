<?php
// ===============================================
// File: views/landing/kontak.php
// Deskripsi: Halaman kontak untuk pengunjung CMSMAHDI
// ===============================================

require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

?>

<div class="container my-5">
  <h3 class="mb-4 border-bottom pb-2">Kontak Kami</h3>
  <p>Silakan kirim pesan, saran, atau pertanyaan Anda melalui formulir di bawah ini.</p>

  <form method="POST" action="#">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama</label>
      <input type="text" id="nama" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="pesan" class="form-label">Pesan</label>
      <textarea id="pesan" name="pesan" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
  </form>
</div>

