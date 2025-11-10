<?php
// ==============================================
// File: pages/user/navbar.php
// Deskripsi: Navbar + Breadcrumb otomatis CMS Mahdi
// ==============================================

$namauser = $_SESSION['namauser'] ?? 'Pengguna';
$role     = $_SESSION['role'] ?? 'User';

/**
 * =====================================================
 * Fungsi otomatis membentuk breadcrumb dan judul halaman
 * =====================================================
 */
function buat_breadcrumb_otomatis()
{
    $hal = $_GET['hal'] ?? 'dashboardadmin';

    // Jika dashboard utama
    if ($hal === 'dashboardadmin' || $hal === 'dashboardeditor') {
        echo '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item active">Dashboard</li></ol>';
        return;
    }

    // Pisahkan bagian path, contoh: user/tambahuser -> ['user', 'tambahuser']
    $parts = explode('/', $hal);
    $breadcrumb = [];
    $url = 'dashboard.php';

    // Tambahkan link Dashboard sebagai awal
    $breadcrumb[] = '<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>';

    // Bangun link bertahap berdasarkan struktur
    for ($i = 0; $i < count($parts); $i++) {
        $segment = htmlspecialchars(ucfirst(str_replace(['_', '-'], ' ', $parts[$i])));

        if ($i < count($parts) - 1) {
            // Bagian tengah breadcrumb (punya link)
            $url .= '?hal=' . implode('/', array_slice($parts, 0, $i + 1));
            $breadcrumb[] = '<li class="breadcrumb-item"><a href="' . htmlspecialchars($url) . '">' . $segment . '</a></li>';
        } else {
            // Bagian terakhir (aktif)
            $breadcrumb[] = '<li class="breadcrumb-item active">' . $segment . '</li>';
        }
    }

    echo '<ol class="breadcrumb float-sm-right">' . implode('', $breadcrumb) . '</ol>';
}

/**
 * =====================================================
 * Fungsi otomatis membuat judul halaman dari parameter hal
 * =====================================================
 */
function judul_halaman_otomatis()
{
    $hal = $_GET['hal'] ?? 'dashboardadmin';

    if ($hal === 'dashboardadmin' || $hal === 'dashboardeditor') {
        return 'Dashboard';
    }

    // Ambil nama terakhir dari path hal (mis: user/tambahuser -> Tambah User)
    $parts = explode('/', $hal);
    $judul = ucfirst(str_replace(['_', '-'], ' ', end($parts)));

    return $judul;
}
?>

<!-- ============================================== -->
<!-- NAVBAR ATAS ADMIN -->
<!-- ============================================== -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <!-- Navigasi kiri -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= url('dashboard.php'); ?>" class="nav-link">Beranda</a>
    </li>
  </ul>

  <!-- Navigasi kanan -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="dropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user-circle"></i> <?= htmlspecialchars($namauser); ?> (<?= htmlspecialchars($role); ?>)
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
        <li><a class="dropdown-item" href="<?= url('user/profil.php'); ?>"><i class="fas fa-id-card me-2"></i> Profil</a></li>
        <li><a class="dropdown-item" href="<?= url('views/auth/logout.php'); ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
      </ul>
    </li>
  </ul>
</nav>

<!-- ============================================== -->
<!-- BAGIAN HEADER + BREADCRUMB GLOBAL -->
<!-- ============================================== -->
<div class="content-header">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <h5 class="m-0"><?= judul_halaman_otomatis(); ?></h5>
    <?php buat_breadcrumb_otomatis(); ?>
  </div>
</div>
