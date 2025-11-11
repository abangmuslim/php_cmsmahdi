<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

// Ambil data dari form
$idkonten = intval($_POST['idkonten'] ?? 0);
$nama     = bersihkan($_POST['namakomentar'] ?? '');
$email    = bersihkan($_POST['email'] ?? '');
$komentar = bersihkan($_POST['isikomentar'] ?? '');

// Pastikan data lengkap
if ($idkonten > 0 && !empty($nama) && !empty($komentar)) {
    $stmt = $koneksi->prepare("
        INSERT INTO komentar (idkonten, namakomentar, email, isikomentar, tanggalbuat, status)
        VALUES (?, ?, ?, ?, NOW(), 'tampil')
    ");
    if ($stmt) {
        $stmt->bind_param("isss", $idkonten, $nama, $email, $komentar);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect kembali ke halaman konten publik
header("Location: " . BASE_URL . "artikel/" . $idkonten);
exit;
