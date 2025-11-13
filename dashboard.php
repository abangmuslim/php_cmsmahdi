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

// Layout default (untuk admin)
$layoutPath = 'pages/user';
$viewFolder = 'views/user';

// Tentukan halaman default & folder view berdasarkan role
if ($role === 'admin') {
    $defaultPage = 'dashboardadmin';
} elseif ($role === 'editor') {
    $defaultPage = 'dashboardeditor';
    $layoutPath = 'pages/user'; // layout tetap sama (header, navbar, footer)
    $viewFolder = 'views/user'; // ✅ gunakan folder views/user karena folder pages/editor tidak ada
} else {
    header("Location: index.php");
    exit;
}

// =======================================
// 2️⃣ Tentukan Halaman yang Diminta
// =======================================
$hal = $_GET['hal'] ?? $defaultPage;

// =======================================
// 3️⃣ Batasi Akses Berdasarkan Role
// =======================================
$allowed_editor_pages = [
    'dashboardeditor',
    'kategori/daftarkategori', 'kategori/tambahkategori', 'kategori/editkategori', 'kategori/proseskategori',
    'konten/daftarkonten', 'konten/tambahkonten', 'konten/editkonten', 'konten/proseskonten',
    'komentar/daftarkomentar', 'komentar/editkomentar', 'komentar/proseskomentar',
    'laporan/daftarlaporan', 'laporan/cetaklaporan'
];

if ($role === 'editor') {
    if (
        str_starts_with($hal, 'user/') ||                 
        str_starts_with($hal, 'dashboardadmin') ||        
        !in_array($hal, $allowed_editor_pages)
    ) {
        $hal = $defaultPage;
    }
}

// =======================================
// 4️⃣ Bangun Path File View Secara Dinamis
// =======================================
$halPath = explode('/', $hal);

if (count($halPath) > 1) {
    $file = BASE_PATH . "/{$viewFolder}/" . implode('/', $halPath) . ".php";
} else {
    $file = BASE_PATH . "/{$viewFolder}/{$hal}.php";
}

// =======================================
// 5️⃣ Fallback Otomatis ke Daftar Utama Jika Tidak Ada File
// =======================================
if (!file_exists($file)) {
    $parts = explode('/', $hal);
    $parent = $parts[0] ?? '';

    $fallbacks = [
        'konten'   => 'konten/daftarkonten',
        'user'     => 'user/daftaruser',
        'kategori' => 'kategori/daftarkategori',
        'komentar' => 'komentar/daftarkomentar',
        'laporan'  => 'laporan/daftarlaporan'
    ];

    if (isset($fallbacks[$parent])) {
        $file = BASE_PATH . "/{$viewFolder}/" . $fallbacks[$parent] . ".php";
    }
}

// =======================================
// 6️⃣ Validasi Akhir File Tujuan
// =======================================
if (!file_exists($file)) {
    $file = BASE_PATH . "/{$viewFolder}/{$defaultPage}.php";
}

// =======================================
// 7️⃣ Tampilkan Layout Backend (AdminLTE)
// =======================================
include BASE_PATH . "/{$layoutPath}/header.php";
include BASE_PATH . "/{$layoutPath}/navbar.php";

if ($role === 'editor') {
    include BASE_PATH . "/{$layoutPath}/sidebareditor.php";
} else {
    include BASE_PATH . "/{$layoutPath}/sidebar.php";
}

include $file;
include BASE_PATH . "/{$layoutPath}/footer.php";
?>
