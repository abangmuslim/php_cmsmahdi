<?php
// ==============================================
// File: views/auth/login.php
// Deskripsi: Form login untuk admin/editor
// ==============================================

require_once '../../includes/konfig.php';
require_once '../../includes/koneksi.php';
session_start();

// Jika sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['iduser'])) {
    header("Location: " . url('dashboard.php'));
    exit;
}

$pesan = '';
if (isset($_GET['pesan'])) {
    $pesan = htmlspecialchars($_GET['pesan']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | <?= $site_name; ?></title>
    <link rel="stylesheet" href="<?= url('asset/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= url('asset/css/auth.css'); ?>">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header text-center bg-primary text-white">
          <h5 class="mb-0">Login <?= $site_name; ?></h5>
        </div>
        <div class="card-body">
          <?php if ($pesan): ?>
            <div class="alert alert-warning text-center"><?= $pesan; ?></div>
          <?php endif; ?>

          <form action="proseslogin.php" method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" id="username" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Masuk</button>
          </form>

          <div class="text-center mt-3">
            <small>Belum punya akun? <a href="register.php">Daftar</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
