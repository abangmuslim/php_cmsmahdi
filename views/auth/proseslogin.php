<?php
// ==============================================
// File: views/auth/proseslogin.php
// Deskripsi: Proses backend login CMSMAHDI (modern password_hash)
// ==============================================

require_once '../../includes/konfig.php';
require_once '../../includes/koneksi.php';
require_once '../../includes/fungsivalidasi.php';
session_start();

// Ambil dan bersihkan input
$username = bersihkan($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input kosong
if (empty($username) || empty($password)) {
    header("Location: login.php?pesan=Isi+semua+kolom");
    exit;
}

// Query user berdasarkan username
$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah user ditemukan
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password hash (modern)
    if (password_verify($password, $user['password'])) {

        // Set session login
        $_SESSION['iduser']    = $user['iduser'];
        $_SESSION['namauser']  = $user['namauser'];
        $_SESSION['role']      = $user['role'];
        $_SESSION['username']  = $user['username'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: " . url('dashboard.php'));
        } elseif ($user['role'] === 'editor') {
            header("Location: " . url('dashboard.php'));
        } else {
            header("Location: login.php?pesan=Role+tidak+valid");
        }
        exit;

    } else {
        // Password salah
        header("Location: login.php?pesan=Password+salah");
        exit;
    }

} else {
    // Username tidak ditemukan
    header("Location: login.php?pesan=Username+tidak+ditemukan");
    exit;
}
?>
