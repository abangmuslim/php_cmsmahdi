<?php
// ===============================================
// File: views/landing/tentang.php
// Deskripsi: Halaman "Tentang" portal CMSMAHDI
// ===============================================

// Muat definisi path dan konfigurasi utama
require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

// Layout bagian atas
include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';
?>

<div class="container my-5">
  <h3 class="mb-3 border-bottom pb-2">Tentang CMSMAHDI</h3>
  <p>
    <strong>CMSMAHDI</strong> adalah sistem manajemen konten (CMS) berbasis <em>PHP Native</em> 
    yang dirancang untuk mendukung dua role utama: 
    <strong>Admin</strong> dan <strong>Editor</strong>.
  </p>
  <p>
    <strong>Admin</strong> memiliki wewenang penuh untuk mengelola user, kategori, konten, 
    dan komentar, sedangkan <strong>Editor</strong> berfokus pada pengelolaan artikel 
    serta tanggapan pembaca.
  </p>
  <p>
    Proyek ini dikembangkan dengan struktur modular, aman, dan mudah diperluas untuk 
    kebutuhan pengelolaan konten skala kecil hingga menengah.
  </p>
</div>

<?php include PAGES_PATH . 'landing/footer.php'; ?>
