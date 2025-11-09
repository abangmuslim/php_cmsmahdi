<?php
// ==============================================
// File: views/auth/proseslogin.php
// Deskripsi: Proses backend login
// ==============================================
require_once '../../includes/konfig.php';
require_once '../../includes/koneksi.php';
require_once '../../includes/fungsivalidasi.php';
session_start();

$username = bersihkan_input($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: login.php?pesan=Isi+semua+kolom");
    exit;
}

$sql = "SELECT * FROM tb_user WHERE username = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Set session
        $_SESSION['iduser'] = $user['iduser'];
        $_SESSION['namauser'] = $user['namapengguna'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: " . url('dashboard.php'));
        } elseif ($user['role'] === 'editor') {
            header("Location: " . url('dashboard.php'));
        } else {
            header("Location: " . url('views/auth/login.php?pesan=Role+tidak+valid'));
        }
        exit;
    } else {
        header("Location: login.php?pesan=Password+salah");
        exit;
    }
} else {
    header("Location: login.php?pesan=Username+tidak+ditemukan");
    exit;
}
