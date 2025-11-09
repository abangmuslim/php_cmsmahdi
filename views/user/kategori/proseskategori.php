<?php
// ===============================================
// File: views/user/kategori/proseskategori.php
// Deskripsi: Logic backend untuk CRUD kategori
// ===============================================

require_once '../../../includes/koneksi.php';
require_once '../../../includes/fungsivalidasi.php';
require_once '../../../includes/ceksession.php';

$aksi = $_GET['aksi'] ?? '';

if ($aksi == 'tambah') {
    $namakategori = bersihkan_input($_POST['namakategori'] ?? '');
    $slug = strtolower(str_replace(' ', '-', $namakategori));

    $stmt = $koneksi->prepare("INSERT INTO tb_kategori (namakategori, slug, tanggal) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $namakategori, $slug);
    $stmt->execute();

    header("Location: daftarkategori.php?status=sukses_tambah");
    exit;

} elseif ($aksi == 'edit') {
    $id = intval($_POST['idkategori']);
    $namakategori = bersihkan_input($_POST['namakategori'] ?? '');
    $slug = strtolower(str_replace(' ', '-', $namakategori));

    $stmt = $koneksi->prepare("UPDATE tb_kategori SET namakategori=?, slug=? WHERE idkategori=?");
    $stmt->bind_param("ssi", $namakategori, $slug, $id);
    $stmt->execute();

    header("Location: daftarkategori.php?status=sukses_edit");
    exit;

} elseif ($aksi == 'hapus') {
    $id = intval($_GET['id']);
    $stmt = $koneksi->prepare("DELETE FROM tb_kategori WHERE idkategori=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: daftarkategori.php?status=sukses_hapus");
    exit;
}
