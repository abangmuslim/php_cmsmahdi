<?php
// ==============================================
// File: pages/user/header.php
// Deskripsi: Bagian <head> untuk halaman admin CMSMAHDI
// ==============================================
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($judul_halaman) ? $judul_halaman . " | " . $site_name : $site_name; ?></title>

  <!-- AdminLTE & Bootstrap CSS -->
  <link rel="stylesheet" href="<?= url('asset/dist/css/adminlte.min.css'); ?>">
  <link rel="stylesheet" href="<?= url('asset/dist/plugins/fontawesome-free/css/all.min.css'); ?>"> <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= url('asset/css/custom.css'); ?>"> <!-- opsional: gaya tambahan -->

  <!-- Ikon & Favicon -->
  <link rel="icon" href="<?= url('asset/img/favicon.png'); ?>">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">