<?php
// ===============================================================
// File: views/user/kategori/proseskategori.php
// Deskripsi: Logic backend CRUD untuk manajemen kategori CMS Mahdi (FINAL VERSION)
// ===============================================================

require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
require_once dirname(__DIR__, 3) . '/includes/fungsivalidasi.php';
require_once dirname(__DIR__, 3) . '/includes/ceksession.php';

// Ambil aksi (prioritaskan POST)
$aksi = $_POST['aksi'] ?? ($_GET['aksi'] ?? '');

// =====================================================
// TAMBAH KATEGORI
// =====================================================
if ($aksi === 'tambah') {
    $nama      = bersihkan($_POST['namakategori'] ?? '');
    $deskripsi = bersihkan($_POST['deskripsi'] ?? '');

    // Validasi wajib isi
    if (empty($nama)) {
        header("Location: ../../../dashboard.php?hal=kategori/tambahkategori&status=error_kosong");
        exit;
    }

    // Simpan ke database
    $stmt = $koneksi->prepare("INSERT INTO kategori (namakategori, deskripsi) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $deskripsi);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=kategori/daftarkategori&status=sukses_tambah");
    exit;
}

// =====================================================
// UPDATE KATEGORI
// =====================================================
elseif ($aksi === 'update') {
    $id        = intval($_POST['idkategori'] ?? 0);
    $nama      = bersihkan($_POST['namakategori'] ?? '');
    $deskripsi = bersihkan($_POST['deskripsi'] ?? '');

    // Validasi wajib isi
    if (empty($nama)) {
        header("Location: ../../../dashboard.php?hal=kategori/editkategori&id=$id&status=error_kosong");
        exit;
    }

    // Update database
    $stmt = $koneksi->prepare("UPDATE kategori SET namakategori=?, deskripsi=? WHERE idkategori=?");
    $stmt->bind_param("ssi", $nama, $deskripsi, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=kategori/daftarkategori&status=sukses_edit");
    exit;
}

// =====================================================
// HAPUS KATEGORI
// =====================================================
elseif ($aksi === 'hapus') {
    $id = intval($_GET['id'] ?? 0);

    // Hapus dari database
    $stmt = $koneksi->prepare("DELETE FROM kategori WHERE idkategori=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=kategori/daftarkategori&status=sukses_hapus");
    exit;
}

// =====================================================
// DEFAULT: AKSI TIDAK VALID
// =====================================================
else {
    header("Location: ../../../dashboard.php?hal=kategori/daftarkategori&status=invalid_aksi");
    exit;
}
?>
