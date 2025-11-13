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
$stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah user ditemukan
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password hash
    if (password_verify($password, $user['password'])) {

        // Set session login
        $_SESSION['iduser']   = $user['iduser'];
        $_SESSION['namauser'] = $user['namauser'];
        $_SESSION['role']     = $user['role'];
        $_SESSION['username'] = $user['username'];

        // ==============================================
        // 🔁 Redirect sesuai role (konsisten dengan struktur CMS)
        // ==============================================
        if ($user['role'] === 'admin') {
            header("Location: " . BASE_URL . "dashboard.php?role=admin");
        } elseif ($user['role'] === 'editor') {
            header("Location: " . BASE_URL . "dashboard.php?role=editor");
        } else {
            // Role tidak dikenal, arahkan ke halaman utama
            header("Location: " . BASE_URL . "index.php?pesan=Role+tidak+dikenal");
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
