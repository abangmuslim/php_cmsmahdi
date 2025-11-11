<?php
// ===============================================================
// File: views/user/komentar/proseskomentar.php
// Deskripsi: Logic backend CRUD untuk manajemen komentar CMS Mahdi
// ===============================================================

require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
require_once dirname(__DIR__, 3) . '/includes/fungsivalidasi.php';
require_once dirname(__DIR__, 3) . '/includes/ceksession.php';

// Ambil aksi
$aksi = $_POST['aksi'] ?? ($_GET['aksi'] ?? '');

// =====================================================
// TAMBAH KOMENTAR
// =====================================================
if ($aksi === 'tambah') {
    $idkonten      = intval($_POST['idkonten'] ?? 0);
    $namakomentar  = bersihkan($_POST['namakomentar'] ?? '');
    $email         = bersihkan($_POST['email'] ?? '');
    $isikomentar   = bersihkan($_POST['isikomentar'] ?? '');
    $status        = bersihkan($_POST['status'] ?? 'tampil');
    $tanggal       = date('Y-m-d H:i:s');

    // Validasi wajib isi
    if ($idkonten <= 0 || empty($namakomentar) || empty($isikomentar)) {
        header("Location: ../../../dashboard.php?hal=komentar/tambahkomentar&status=error_kosong");
        exit;
    }

    $stmt = $koneksi->prepare("INSERT INTO komentar (idkonten, namakomentar, email, isikomentar, status, tanggalbuat) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $idkonten, $namakomentar, $email, $isikomentar, $status, $tanggal);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=komentar/daftarkomentar&status=sukses_tambah");
    exit;
}

// =====================================================
// UPDATE KOMENTAR
// =====================================================
elseif ($aksi === 'update') {
    $idkomentar    = intval($_POST['idkomentar'] ?? 0);
    $idkonten      = intval($_POST['idkonten'] ?? 0);
    $namakomentar  = bersihkan($_POST['namakomentar'] ?? '');
    $email         = bersihkan($_POST['email'] ?? '');
    $isikomentar   = bersihkan($_POST['isikomentar'] ?? '');
    $status        = bersihkan($_POST['status'] ?? 'tampil');

    if ($idkonten <= 0 || empty($namakomentar) || empty($isikomentar)) {
        header("Location: ../../../dashboard.php?hal=komentar/editkomentar&id=$idkomentar&status=error_kosong");
        exit;
    }

    $stmt = $koneksi->prepare("UPDATE komentar SET idkonten=?, namakomentar=?, email=?, isikomentar=?, status=? WHERE idkomentar=?");
    $stmt->bind_param("issssi", $idkonten, $namakomentar, $email, $isikomentar, $status, $idkomentar);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=komentar/daftarkomentar&status=sukses_edit");
    exit;
}

// =====================================================
// HAPUS KOMENTAR
// =====================================================
elseif ($aksi === 'hapus') {
    $idkomentar = intval($_GET['id'] ?? 0);

    $stmt = $koneksi->prepare("DELETE FROM komentar WHERE idkomentar=?");
    $stmt->bind_param("i", $idkomentar);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=komentar/daftarkomentar&status=sukses_hapus");
    exit;
}

// =====================================================
// DEFAULT: AKSI TIDAK VALID
// =====================================================
else {
    header("Location: ../../../dashboard.php?hal=komentar/daftarkomentar&status=invalid_aksi");
    exit;
}
?>
