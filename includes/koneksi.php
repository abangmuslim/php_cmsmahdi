<?php
// ==============================================
// File: includes/koneksi.php
// Deskripsi: Koneksi utama ke database CMSMAHDI
// ==============================================

$host = "localhost";
$user = "root";
$pass = "";
$db   = "cmsmahdi";

// Buat koneksi
$koneksi = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Set karakter agar mendukung UTF-8
$koneksi->set_charset("utf8mb4");

// Tambahan kompatibilitas
$conn = $koneksi;
?>
