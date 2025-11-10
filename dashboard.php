<?php
// =======================================
// File: dashboard.php - Pusat Routing Backend CMSMAHDI
// =======================================

require_once __DIR__ . '/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// =======================================
// 1️⃣ Validasi Role Login
// =======================================
$role = $_SESSION['role'] ?? '';

// Tentukan layout dan folder view berdasarkan role
if ($role === 'admin') {
    $layoutPath   = 'pages/user';      // layout admin (header, navbar, sidebar)
    $viewFolder   = 'views/user';      // folder utama view admin
    $defaultPage  = 'dashboardadmin';  // halaman default admin
} elseif ($role === 'editor') {
    $layoutPath   = 'pages/editor';    // layout editor (lebih sederhana)
    $viewFolder   = 'views/editor';
    $defaultPage  = 'dashboardeditor';
} else {
    // Jika bukan admin/editor, arahkan kembali ke halaman utama
    header("Location: index.php");
    exit;
}

// =======================================
// 2️⃣ Tentukan Halaman yang Diminta
// =======================================
$hal = $_GET['hal'] ?? $defaultPage;

// Cegah akses silang: editor tidak boleh membuka halaman admin
if ($role === 'editor' && str_contains($hal, 'admin')) {
    $hal = 'dashboardeditor';
}

// =======================================
// 3️⃣ Bangun Path File View Secara Dinamis
//    (Dukung struktur subfolder seperti user/daftaruser)
// =======================================
$halPath = explode('/', $hal);

if (count($halPath) > 1) {
    // Contoh: hal=user/daftaruser → views/user/user/daftaruser.php
    $file = BASE_PATH . "/{$viewFolder}/" . implode('/', $halPath) . ".php";
} else {
    // Contoh: hal=dashboardadmin → views/user/dashboardadmin.php
    $file = BASE_PATH . "/{$viewFolder}/{$hal}.php";
}

// =======================================
// 4️⃣ Validasi File Tujuan
// =======================================
if (!file_exists($file)) {
    // Jika file tidak ditemukan, tampilkan dashboard default sesuai role
    $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
}

// =======================================
// 5️⃣ Tampilkan Layout Backend (AdminLTE)
// =======================================
include BASE_PATH . "/{$layoutPath}/header.php";
include BASE_PATH . "/{$layoutPath}/navbar.php";
include BASE_PATH . "/{$layoutPath}/sidebar.php";
include $file; // Halaman dinamis (CRUD, dashboard, dll)
include BASE_PATH . "/{$layoutPath}/footer.php";

?>
