<?php
// ==============================================
// File: includes/konfig.php
// Deskripsi: Variabel global dan pengaturan situs
// ==============================================

// Base URL (ubah sesuai folder kamu)
define('BASE_URL', 'http://localhost/cmsmahdi/');
$base_url  = BASE_URL;
$site_name = "CMSMAHDI";
$versi     = "1.0.0";
$penulis   = "Ahmadi Enam";

date_default_timezone_set('Asia/Jakarta');

// Fungsi sederhana untuk mencetak base_url dengan path tambahan
function url($path = '') {
    return BASE_URL . ltrim($path, '/');
}
