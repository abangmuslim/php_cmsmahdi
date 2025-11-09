<?php
// ==============================================
// File: includes/fungsivalidasi.php
// Deskripsi: Fungsi sanitasi input & validasi form
// ==============================================

// Bersihkan input teks
function bersihkan($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Validasi form wajib diisi
function wajib($data) {
    return !empty(trim($data));
}

// Validasi email sederhana
function valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validasi panjang minimum teks
function min_length($data, $panjang) {
    return strlen(trim($data)) >= $panjang;
}
?>
