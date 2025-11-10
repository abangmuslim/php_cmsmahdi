<?php
// ====================================================
// File: views/landing/kontak.php
// Deskripsi: Halaman kontak publik untuk CMS Mahdi
// ====================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
?>

<!-- ==================================================== -->
<!-- STRUKTUR HALAMAN KONTAK (KONSISTEN DENGAN LOGIN.PHP) -->
<!-- ==================================================== -->
<div class="d-flex flex-column min-vh-100">

  <main class="flex-fill d-flex align-items-center justify-content-center">
    <div class="container py-4">
      <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
          <div class="card shadow-lg border-0">
            <div class="card-body p-4">
              <h3 class="text-center mb-3 border-bottom pb-2">Kontak Kami</h3>
              <p class="text-center mb-4 text-muted">
                Silakan kirim pesan, saran, atau pertanyaan Anda melalui formulir di bawah ini.
              </p>

              <form method="POST" action="<?= BASE_URL ?>index.php?hal=kontak">
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

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </div>
              </form>

              <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>">← Kembali ke Beranda</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

</div>
