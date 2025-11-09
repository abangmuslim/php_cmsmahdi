<?php
// ==============================================
// File: pages/user/navbar.php
// Deskripsi: Navigasi atas admin
// ==============================================
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= url('dashboard.php'); ?>"><?= $site_name; ?></a>
    <div class="d-flex">
      <span class="navbar-text me-3">👤 <?= htmlspecialchars($namauser); ?> (<?= $role; ?>)</span>
      <a href="<?= url('views/auth/logout.php'); ?>" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>
