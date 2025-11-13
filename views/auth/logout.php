<?php
// ==============================================
// File: views/auth/logout.php
// Deskripsi: Logout user dan hapus session
// ==============================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';

// Mulai sesi jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hapus semua data sesi
$_SESSION = [];
session_unset();
session_destroy();

// Redirect ke halaman home dengan pesan logout
header("Location: " . url('?hal=home&pesan=Anda+telah+logout'));
exit;
