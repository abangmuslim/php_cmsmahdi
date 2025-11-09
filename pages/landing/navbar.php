<?php
// ==============================================
// File: pages/landing/navbar.php
// Deskripsi: Navigasi utama portal berita
// ==============================================
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= url(); ?>"><?= $site_name; ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a href="<?= url(); ?>" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="<?= url('kategori.php'); ?>" class="nav-link">Kategori</a></li>
        <li class="nav-item"><a href="<?= url('tentang.php'); ?>" class="nav-link">Tentang</a></li>
      </ul>
      <a href="<?= url('views/auth/login.php'); ?>" class="btn btn-outline-primary btn-sm">Login</a>
    </div>
  </div>
</nav>
