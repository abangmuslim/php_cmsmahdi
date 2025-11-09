<?php
// ===============================================
// File: views/landing/proseskomentar.php
// Deskripsi: Proses simpan komentar pembaca pada CMSMAHDI
// ===============================================

// Muat konfigurasi path dan koneksi
require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'fungsivalidasi.php';

// Ambil data dari form dengan validasi dasar
$idkonten = isset($_POST['idkonten']) ? intval($_POST['idkonten']) : 0;
$nama = bersihkan_input($_POST['namakomentator'] ?? '');
$komentar = bersihkan_input($_POST['isikomentar'] ?? '');

// Pastikan semua input terisi sebelum simpan
if ($idkonten > 0 && !empty($nama) && !empty($komentar)) {
    $stmt = $koneksi->prepare("
        INSERT INTO komentar (idkonten, namakomentator, isikomentar, tanggal) 
        VALUES (?, ?, ?, NOW())
    ");
    if ($stmt) {
        $stmt->bind_param("iss", $idkonten, $nama, $komentar);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect kembali ke halaman detail konten
header("Location: detilkonten.php?id=" . $idkonten);
exit;
