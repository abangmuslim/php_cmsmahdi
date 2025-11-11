<?php
// ==============================================
// File: includes/konfig.php
// Deskripsi: Variabel global dan pengaturan situs CMS Mahdi
// ==============================================

// Base URL (ubah sesuai folder CMS Mahdi)
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/cmsmahdi/');
}

$base_url  = BASE_URL;
$site_name = "CMSMAHDI";
$versi     = "1.0.0";
$penulis   = "Ahmadi Enam";

// Set timezone default
date_default_timezone_set('Asia/Jakarta');

// ==============================================
// Fungsi helper
// ==============================================

// Fungsi untuk mencetak URL lengkap dengan path tambahan
function url($path = '') {
    return BASE_URL . ltrim($path, '/');
}
?>
