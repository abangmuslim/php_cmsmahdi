<?php
// ==============================================
// File: views/auth/register.php
// Deskripsi: Form pendaftaran user baru
// ==============================================

require_once '../../includes/konfig.php';
require_once '../../includes/koneksi.php';
session_start();

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
  <title>Register | <?= $site_name; ?></title>
  <link rel="stylesheet" href="<?= url('asset/css/bootstrap.min.css'); ?>">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
          <h5>Daftar Akun Baru</h5>
        </div>
        <div class="card-body">
          <?php if ($pesan): ?>
            <div class="alert alert-warning text-center"><?= $pesan; ?></div>
          <?php endif; ?>

          <form action="prosesregister.php" method="POST">
            <div class="mb-3">
              <label for="namapengguna" class="form-label">Nama Lengkap</label>
              <input type="text" name="namapengguna" id="namapengguna" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Daftar</button>
          </form>

          <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="login.php">Login</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
