<?php
// ===============================================
// File: views/user/user/prosesuser.php
// Deskripsi: Logic backend untuk CRUD user
// ===============================================

require_once '../../../includes/koneksi.php';
require_once '../../../includes/fungsivalidasi.php';
require_once '../../../includes/ceksession.php';

$aksi = $_GET['aksi'] ?? '';

if ($aksi == 'tambah') {
    $nama = bersihkan_input($_POST['namauser'] ?? '');
    $username = bersihkan_input($_POST['username'] ?? '');
    $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $role = bersihkan_input($_POST['role'] ?? 'editor');
    $foto = '';

    // Upload foto jika ada
    if (!empty($_FILES['foto']['name'])) {
        include '../../../includes/fungsiupload.php';
        $foto = upload_gambar($_FILES['foto'], '../../../uploads/user/');
    }

    $stmt = $koneksi->prepare("INSERT INTO tb_user (namauser, username, password, role, foto, tanggal) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $nama, $username, $password, $role, $foto);
    $stmt->execute();
    header("Location: daftaruser.php?status=sukses_tambah");
    exit;

} elseif ($aksi == 'edit') {
    $id = intval($_POST['iduser']);
    $nama = bersihkan_input($_POST['namauser'] ?? '');
    $username = bersihkan_input($_POST['username'] ?? '');
    $role = bersihkan_input($_POST['role'] ?? 'editor');

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $updatePass = ", password='$password'";
    } else {
        $updatePass = '';
    }

    $fotoBaru = '';
    if (!empty($_FILES['foto']['name'])) {
        include '../../../includes/fungsiupload.php';
        $fotoBaru = upload_gambar($_FILES['foto'], '../../../uploads/user/');
        $updateFoto = ", foto='$fotoBaru'";
    } else {
        $updateFoto = '';
    }

    $sql = "UPDATE tb_user SET namauser='$nama', username='$username', role='$role' $updatePass $updateFoto WHERE iduser=$id";
    $koneksi->query($sql);
    header("Location: daftaruser.php?status=sukses_edit");
    exit;

} elseif ($aksi == 'hapus') {
    $id = intval($_GET['id']);
    $koneksi->query("DELETE FROM tb_user WHERE iduser=$id");
    header("Location: daftaruser.php?status=sukses_hapus");
    exit;
}
