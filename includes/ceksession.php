<?php
// ==============================================
// File: includes/ceksession.php
// Deskripsi: Cek login admin/editor dan redirect jika belum login
// ==============================================

session_start();

// Jika belum login, kembalikan ke halaman login
if (!isset($_SESSION['iduser']) || !isset($_SESSION['role'])) {
    header("Location: views/auth/login.php");
    exit();
}

// Ambil data session jika dibutuhkan
$iduser = $_SESSION['iduser'];
$namauser = $_SESSION['namauser'];
$role = $_SESSION['role'];
?>
