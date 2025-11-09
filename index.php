<?php
// =======================================
// index.php - Pusat Routing Publik (Landing Page)
// =======================================

require_once __DIR__ . '/includes/koneksi.php';
require_once __DIR__ . '/includes/konfig.php';

// Ambil parameter halaman
$hal = $_GET['hal'] ?? 'home';

// Path file konten publik
$file = __DIR__ . "/views/landing/{$hal}.php";

// Jika file tidak ada, arahkan ke halaman 404
if (!file_exists($file)) {
    $file = __DIR__ . "/views/landing/404.php";
}

// Layout publik (front office)
include __DIR__ . "/pages/landing/header.php";
include __DIR__ . "/pages/landing/navbar.php";
include $file;
include __DIR__ . "/pages/landing/footer.php";
