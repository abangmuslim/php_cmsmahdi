<?php
// ==============================================
// File: pages/user/sidebar.php
// Deskripsi: Sidebar menu admin CMSMAHDI (dengan foto user aktif)
// ==============================================

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../../includes/path.php';
require_once __DIR__ . '/../../includes/koneksi.php';

// Ambil data user login
$foto_user = 'default.png'; // default
$nama_user = $_SESSION['namauser'] ?? 'Pengguna';
$role_user = $_SESSION['role'] ?? 'Guest';
$iduser    = $_SESSION['iduser'] ?? 0;

if ($iduser) {
  $stmt = $koneksi->prepare("SELECT foto FROM user WHERE iduser = ?");
  $stmt->bind_param("i", $iduser);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    if (!empty($row['foto']) && file_exists(__DIR__ . '/../../uploads/user/' . $row['foto'])) {
      $foto_user = $row['foto'];
    }
  }
  $stmt->close();
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= url('dashboard.php'); ?>" class="brand-link">
    <img src="<?= url('asset/img/logo.png'); ?>" alt="Logo CMSMAHDI" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= $site_name ?? 'CMS Mahdi'; ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Panel Profil User -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <img src="<?= url('uploads/user/' . htmlspecialchars($foto_user)); ?>"
          class="img-circle elevation-2" alt="User Image"
          style="width: 35px; height: 35px; object-fit: cover;">
      </div>
      <div class="info">
        <a href="<?= url('dashboard.php?hal=user/profil'); ?>" class="d-block">
          <?= htmlspecialchars($nama_user); ?>
        </a>
        <small class="text-muted text-sm"><?= ucfirst($role_user); ?></small>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a></li>
        <li class="nav-item"><a href="dashboard.php?hal=user/daftaruser" class="nav-link"><i class="nav-icon fas fa-users"></i>
            <p>Kelola User</p>
          </a></li>
        <li class="nav-item"><a href="dashboard.php?hal=kategori/daftarkategori" class="nav-link"><i class="nav-icon fas fa-folder"></i>
            <p>Kategori</p>
          </a></li>
        <li class="nav-item"><a href="dashboard.php?hal=konten/daftarkonten" class="nav-link"><i class="nav-icon fas fa-newspaper"></i>
            <p>Konten</p>
          </a></li>
        <li class="nav-item"><a href="dashboard.php?hal=komentar/daftarkomentar" class="nav-link"><i class="nav-icon fas fa-comments"></i>
            <p>Komentar</p>
          </a></li>
        <li class="nav-item">
          <a href="dashboard.php?hal=laporan/daftarlaporan" class="nav-link">
            <i class="fas fa-chart-line"></i>
            <p>Laporan</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>