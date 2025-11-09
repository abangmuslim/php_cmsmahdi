<?php
// ==============================================
// File: pages/editor/header.php
// Deskripsi: Head HTML untuk editor
// ==============================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($judul_halaman) ? $judul_halaman . " | " . $site_name : $site_name; ?></title>

    <link rel="stylesheet" href="<?= url('asset/css/editor.css'); ?>">
    <link rel="stylesheet" href="<?= url('asset/css/bootstrap.min.css'); ?>">
</head>
<body>
