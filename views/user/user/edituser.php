<?php
// =============================================
// File: views/user/user/edituser.php
// Deskripsi: Form edit data user (Admin Only) versi 2 kolom
// =============================================

require_once dirname(__DIR__, 3) . '/includes/konfig.php';
require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
require_once dirname(__DIR__, 3) . '/includes/ceksession.php';

// Pastikan hanya admin yang bisa akses
if ($role !== 'admin') {
  header("Location: ../../../index.php");
  exit;
}

// Ambil data user berdasarkan id
$iduser = $_GET['id'] ?? 0;
$query  = mysqli_query($koneksi, "SELECT * FROM user WHERE iduser = '$iduser'");
$data   = mysqli_fetch_assoc($query);

if (!$data) {
  echo "<div class='alert alert-danger'>Data user tidak ditemukan!</div>";
  exit;
}

// Tentukan path foto
$fotoPath = "uploads/user/" . htmlspecialchars($data['foto']);
if (!file_exists(dirname(__DIR__, 3) . "/$fotoPath") || empty($data['foto'])) {
  $fotoPath = "uploads/user/default.png";
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fas fa-user-edit"></i> Edit User</h1>
  </section>

  <section class="content">
    <div class="card card-primary">
      <div class="card-header bg-gradient-primary">
        <h3 class="card-title"><i class="fas fa-edit"></i> Form Edit Data User</h3>
      </div>

      <form method="POST" action="views/user/user/prosesuser.php" enctype="multipart/form-data">
        <input type="hidden" name="aksi" value="update">
        <input type="hidden" name="iduser" value="<?= htmlspecialchars($data['iduser']) ?>">
        <input type="hidden" name="fotolama" value="<?= htmlspecialchars($data['foto']) ?>">

        <div class="card-body">
          <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="namauser" class="form-control" value="<?= htmlspecialchars($data['namauser']) ?>" required>
              </div>

              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
              </div>

              <div class="form-group">
                <label>Password (Kosongkan jika tidak diubah)</label>
                <div class="input-group">
                  <input id="password" type="password" name="password" class="form-control" placeholder="••••••••">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                      <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
              </div>

              <div class="form-group mt-3 text-left">
                <label>Role</label>
                <select name="role" class="form-control" required>
                  <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                  <option value="editor" <?= $data['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                </select>
              </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6 text-center">
              <label>Foto Saat Ini</label><br>
              <img id="previewFoto" src="<?= $fotoPath ?>" alt="Foto User" class="img-thumbnail mb-2" width="250">
              <input type="file" name="foto" id="fotoInput" class="form-control mt-2" accept="image/*">

            </div>
          </div>
        </div>

        <!-- Footer kanan bawah -->
        <div class="card-footer text-right">
          <a href="dashboard.php?hal=user/daftaruser" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
          <button type="reset" class="btn btn-warning btn-sm"><i class="fas fa-retweet"></i> Reset</button>
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </section>
</div>

<!-- Preview foto otomatis -->
<script>
  document.getElementById('fotoInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('previewFoto').src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
</script>

<!-- Toggle Password (stabil, tanpa delay) -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('togglePassword');
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');

    btn.addEventListener('click', function() {
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  });
</script>