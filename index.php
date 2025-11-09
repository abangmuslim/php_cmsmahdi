<?php
// ===============================================
// File: index.php (root)
// Deskripsi: Routing utama untuk tampilan publik CMSMAHDI
// ===============================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Tentukan halaman berdasarkan parameter 'hal'
$halaman = $_GET['hal'] ?? 'home';

// Bersihkan dari ekstensi .php (kalau user ketik kategori.php)
$halaman = str_replace('.php', '', $halaman);

// Routing file halaman publik
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

  default:
    $file_view = VIEWS_PATH . 'landing/404.php';
    break;
}

// Tampilkan layout landing umum
include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';

// Panggil file halaman jika ada
if (file_exists($file_view)) {
  include $file_view;
} else {
  include VIEWS_PATH . 'landing/404.php';
}

include PAGES_PATH . 'landing/footer.php';
