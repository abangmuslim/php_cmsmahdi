<?php
// ==============================================
// File: pages/user/header.php
// Deskripsi: Header utama untuk layout Admin CMS Mahdi (Admin / Editor)
// ==============================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= htmlspecialchars($site_name); ?> - Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Favicon -->
  <link rel="icon" href="<?= BASE_URL ?>asset/dist/img/logo.png" type="image/png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/plugins/fontawesome/css/all.min.css">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/plugins/bootstrap/css/bootstrap.min.css">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/dist/css/adminlte.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/plugins/datatables/datatables.min.css">

  <!-- Summernote -->
  <link rel="stylesheet" href="<?= BASE_URL ?>asset/plugins/summernote/summernote-bs4.min.css">

  <!-- Custom CSS -->
  <style>
    .content-wrapper {
      background-color: #f4f6f9;
      padding: 20px;
      min-height: 100vh;
    }

    .table img {
      border-radius: 6px;
    }

    .note-editor {
      border-radius: 8px;
    }

    .main-sidebar {
      background: #343a40;
    }

    .main-footer {
      background: #fff;
      border-top: 1px solid #dee2e6;
      padding: 10px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
