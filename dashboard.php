<?php
// =======================================
// dashboard.php - Pusat Routing Backend
// =======================================

session_start();
require_once __DIR__ . '/includes/koneksi.php';
require_once __DIR__ . '/includes/ceksession.php';

// Cek role user
$role = $_SESSION['role'] ?? null;
if (!$role) {
    header("Location: views/auth/login.php");
    exit;
}

// Tentukan layout berdasarkan role
$layoutPath = ($role === 'admin') ? 'pages/user' : 'pages/editor';

// Ambil parameter halaman
$hal = $_GET['hal'] ?? 'dashboardadmin';
if ($role === 'editor' && $hal === 'dashboardadmin') {
    $hal = 'dashboardeditor'; // ganti otomatis untuk editor
}

// Path file konten (berada di views/user/)
$file = __DIR__ . "/views/user/{$hal}.php";
if (!file_exists($file)) {
    $file = __DIR__ . "/views/user/dashboardadmin.php";
}

// Tampilkan layout backend
include __DIR__ . "/{$layoutPath}/header.php";
include __DIR__ . "/{$layoutPath}/navbar.php";
include __DIR__ . "/{$layoutPath}/sidebar.php";
include $file;
include __DIR__ . "/{$layoutPath}/footer.php";
