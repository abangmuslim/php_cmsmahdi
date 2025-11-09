<?php
// ===============================================
// File: views/landing/tentang.php
// Deskripsi: Halaman "Tentang" portal CMSMAHDI
// ===============================================

require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
?>

<!-- Wrapper agar footer tetap di bawah -->
<div class="d-flex flex-column min-vh-100">

  <!-- Konten utama -->
  <main class="flex-fill">
    <div class="container my-5">
      <div class="row">
        <!-- Kolom utama -->
        <div class="col-md-8">
          <h3 class="mb-3 border-bottom pb-2">Tentang CMSMAHDI</h3>
          <p>
            <strong>CMSMAHDI</strong> adalah sistem manajemen konten (CMS) berbasis 
            <em>PHP Native</em> yang dirancang untuk mendukung dua peran utama:
            <strong>Admin</strong> dan <strong>Editor</strong>.
          </p>
          <p>
            <strong>Admin</strong> memiliki wewenang penuh untuk mengelola pengguna, kategori, 
            konten, dan komentar, sementara <strong>Editor</strong> fokus pada pembuatan dan 
            pengelolaan artikel.
          </p>
          <p>
            CMSMAHDI dikembangkan dengan struktur modular, aman, dan mudah diperluas 
            untuk kebutuhan portal berita skala kecil hingga menengah.
          </p>
        </div>

        <!-- Sidebar kanan -->
        <div class="col-md-4">
          <?php include PAGES_PATH . 'landing/sidebar-right.php'; ?>
        </div>
      </div>
    </div>
  </main>

</div>

