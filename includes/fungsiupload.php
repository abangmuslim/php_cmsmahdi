<?php
// ==============================================
// File: includes/fungsiupload.php
// Deskripsi: Fungsi upload gambar untuk user/konten/komentar CMS Mahdi
// ==============================================

function upload_gambar($fileArray, $folderTujuan) {
    // Pastikan array file valid
    if (!isset($fileArray['name']) || $fileArray['error'] !== UPLOAD_ERR_OK) {
        return 'default.png';
    }

    // Pastikan folder ada
    if (!file_exists($folderTujuan)) {
        mkdir($folderTujuan, 0755, true);
    }

    // Ambil nama & ekstensi file
    $namaFile = basename($fileArray['name']);
    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    // Validasi ekstensi
    $extValid = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $extValid)) {
        return 'default.png';
    }

    // Validasi ukuran (maks 2MB)
    if ($fileArray['size'] > 2000000) {
        return 'default.png';
    }

    // Buat nama unik
    $namaBaru = time() . '_' . rand(100, 999) . '.' . $ext;
    $targetFile = rtrim($folderTujuan, '/') . '/' . $namaBaru;

    // Pindahkan file
    if (move_uploaded_file($fileArray['tmp_name'], $targetFile)) {
        return $namaBaru;
    } else {
        return 'default.png';
    }
}
?>
