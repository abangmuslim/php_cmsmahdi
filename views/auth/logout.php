<?php
// ==============================================
// File: views/auth/logout.php
// Deskripsi: Logout user dan hapus session
// ==============================================
session_start();
session_unset();
session_destroy();

require_once '../../includes/konfig.php';
header("Location: " . url('views/auth/login.php?pesan=Anda+telah+logout'));
exit;
