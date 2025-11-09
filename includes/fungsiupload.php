<?php
// ==============================================
// File: includes/fungsiupload.php
// Deskripsi: Fungsi upload gambar untuk user/konten/komentar
// ==============================================

function upload_gambar($file_input, $folder_tujuan) {
    $target_dir = "uploads/" . $folder_tujuan . "/";
    $nama_file = basename($_FILES[$file_input]["name"]);
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    // Validasi tipe file
    $tipe_diizinkan = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $tipe_diizinkan)) {
        return ["status" => false, "pesan" => "Tipe file tidak diizinkan"];
    }

    // Validasi ukuran (maks 2 MB)
    if ($_FILES[$file_input]["size"] > 2000000) {
        return ["status" => false, "pesan" => "Ukuran file terlalu besar (maks 2 MB)"];
    }

    // Rename file unik
    $nama_baru = time() . "_" . rand(100, 999) . "." . $ext;
    $target_file = $target_dir . $nama_baru;

    // Pastikan folder ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Pindahkan file
    if (move_uploaded_file($_FILES[$file_input]["tmp_name"], $target_file)) {
        return ["status" => true, "nama" => $nama_baru];
    } else {
        return ["status" => false, "pesan" => "Gagal mengunggah file"];
    }
}
?>
