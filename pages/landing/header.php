<?php
// ==============================================
// File: pages/landing/header.php
// Deskripsi: Head HTML umum portal berita
// ==============================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal berita <?= $site_name; ?> - terbaru dan terpercaya.">
    <meta name="keywords" content="berita, cms, portal, <?= $site_name; ?>">
    <meta name="author" content="<?= $penulis; ?>">
    <title><?= isset($judul_halaman) ? $judul_halaman . " | " . $site_name : $site_name; ?></title>


    <link rel="stylesheet" href="<?= BASE_URL; ?>/asset/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/asset/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/asset/pluggin/datatables/datatables.min.css">

</head>

<body>