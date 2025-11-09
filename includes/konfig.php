<?php
// ==============================================
// File: includes/konfig.php
// Deskripsi: Variabel global dan pengaturan situs
// ==============================================
define('BASE_URL', 'http://localhost/cmsmahdi');
$base_url   = "http://localhost/cmsmahdi/";
$site_name  = "CMSMAHDI";
$versi      = "1.0.0";
$penulis    = "Ahmadi Enam";

date_default_timezone_set('Asia/Jakarta');

// Fungsi sederhana untuk mencetak base_url
function url($path = '') {
    global $base_url;
    return $base_url . ltrim($path, '/');
}
?>
