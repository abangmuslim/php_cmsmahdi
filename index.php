<?php
// ===============================================
// File: index.php (root)
// Deskripsi: Routing utama untuk tampilan publik CMSMAHDI
// ===============================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Mulai sesi untuk deteksi login
session_start();

// Ambil parameter 'hal' dari URL (misal: ?hal=kategori&id=3)
$halaman = isset($_GET['hal']) ? trim($_GET['hal']) : 'home';

// Bersihkan nama file dari ekstensi .php atau karakter berbahaya
$halaman = basename(str_replace('.php', '', $halaman));

// Tentukan path file view berdasarkan parameter halaman
switch ($halaman) {
  case '':
  case 'home':
    $file_view = VIEWS_PATH . 'landing/home.php';
    break;

  case 'detilkonten':
    $file_view = VIEWS_PATH . 'landing/detilkonten.php';
    break;

  case 'kategori':
    $file_view = VIEWS_PATH . 'landing/kategori.php';
    break;

  case 'tentang':
    $file_view = VIEWS_PATH . 'landing/tentang.php';
    break;

  case 'kontak':
    $file_view = VIEWS_PATH . 'landing/kontak.php';
    break;

  // 🔐 Halaman login publik (bukan dashboard admin)
  case 'login':
    $file_view = VIEWS_PATH . 'auth/login.php';
    break;

  // Jika halaman tidak dikenali
  default:
    $file_view = VIEWS_PATH . 'landing/404.php';
    break;
}

// ======================================================
//  TEMPLATE LANDING: HEADER + NAVBAR + CONTENT + FOOTER
// ======================================================
include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';

// Muat file konten utama
if (file_exists($file_view)) {
  include $file_view;
} else {
  include VIEWS_PATH . 'landing/404.php';
}

include PAGES_PATH . 'landing/footer.php';
