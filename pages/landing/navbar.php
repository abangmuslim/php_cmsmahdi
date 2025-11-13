<?php
// ==============================================
// File: pages/landing/navbar.php
// Deskripsi: Navigasi utama front-end CMSMAHDI + Breadcrumb otomatis
// ==============================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../includes/path.php';

// Ambil nama halaman aktif dari URL
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_values(array_filter(explode('/', trim($uri_path, '/'))));
$current_page = $segments[count($segments) - 1] ?? 'beranda';
$current_page = str_replace(['index.php'], '', $current_page);
$current_page = $current_page ?: 'beranda';

// Mapping label otomatis
$label_map = [
  'beranda'  => 'Beranda',
  'index'    => 'Beranda',
  'kategori' => 'Kategori',
  'tentang'  => 'Tentang Kami',
  'kontak'   => 'Kontak',
  'login'    => 'Login',
  'dashboard.php' => 'Dashboard'
];
$current_label = $label_map[$current_page] ?? ucfirst(str_replace(['-', '_', '.php'], ' ', $current_page));
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">CMS Mahdi</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php
        // Daftar menu utama
        $menu = [
          'beranda'  => ['label' => 'Beranda', 'url' => BASE_URL],
          'kategori' => ['label' => 'Kategori', 'url' => BASE_URL . 'kategori'],
          'tentang'  => ['label' => 'Tentang Kami', 'url' => BASE_URL . 'tentang'],
          'kontak'   => ['label' => 'Kontak', 'url' => BASE_URL . 'kontak']
        ];

        // Render menu utama otomatis
        foreach ($menu as $key => $item) {
          $active = ($current_page === $key) ? 'active fw-bold' : '';
          echo "<li class='nav-item'><a class='nav-link $active' href='{$item['url']}'>{$item['label']}</a></li>";
        }
        ?>

        <!-- Menu login/dashboard otomatis -->
        <?php if (empty($_SESSION['role'])): ?>
          <li class="nav-item">
            <a class="nav-link <?= ($current_page === 'login') ? 'active fw-bold' : '' ?>" href="<?= BASE_URL ?>login">
              <i class="fas fa-sign-in-alt me-1"></i> Login
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle me-1"></i>
              <?= htmlspecialchars($_SESSION['namauser'] ?? ucfirst($_SESSION['role'])); ?>
              (<?= htmlspecialchars($_SESSION['role']); ?>)
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="<?= BASE_URL ?>dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
              </li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>views/auth/logout.php">
                <i class="fas fa-sign-out-alt me-2"></i> Logout</a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Breadcrumb otomatis -->
<div class="bg-light py-2 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Beranda</a></li>
        <?php
        // Jika halaman adalah artikel/id, tampilkan judul kontennya
        if (strpos($_SERVER['REQUEST_URI'], '/artikel/') !== false) {
            require_once INCLUDES_PATH . 'koneksi.php';
            $parts = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
            $idkonten = end($parts);
            $judul = '';

            if (is_numeric($idkonten)) {
                $stmt = $koneksi->prepare("SELECT judulkonten FROM konten WHERE idkonten = ?");
                $stmt->bind_param('i', $idkonten);
                $stmt->execute();
                $stmt->bind_result($judul);
                $stmt->fetch();
                $stmt->close();
            }

            if (!empty($judul)) {
                echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($judul) . '</li>';
            } else {
                echo '<li class="breadcrumb-item active" aria-current="page">Artikel</li>';
            }
        } elseif ($current_page !== 'beranda') {
            echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($current_label) . '</li>';
        }
        ?>
      </ol>
    </nav>
  </div>
</div>

