<?php
// ==============================================
// File: views/user/user/tambahuser.php
// Deskripsi: Form tambah user CMS Mahdi versi 2 kolom, update password toggle & foto besar
// ==============================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fas fa-user-plus"></i> Tambah User</h1>
  </section>

  <section class="content">
    <div class="card card-success">
      <div class="card-header bg-gradient-success">
        <h3 class="card-title"><i class="fas fa-plus-circle"></i> Form Tambah User</h3>
      </div>

      <form action="views/user/user/prosesuser.php" method="POST" enctype="multipart/form-data">
        <div class="card-body">
          <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="namauser" class="form-control" placeholder="Masukkan nama lengkap" required>
              </div>

              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
              </div>

              <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                  <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                      <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
              </div>

              <div class="form-group mt-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                  <option value="">-- Pilih Role --</option>
                  <option value="admin">Admin</option>
                  <option value="editor">Editor</option>
                </select>
              </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6 text-center">
              <div class="form-group">
                <label>Foto</label><br>
                <input type="file" name="foto" id="fotoInput" class="form-control-file" accept=".jpg,.jpeg,.png,.gif,.webp">
                <small class="form-text text-muted">Maksimal 2MB (jpg, png, gif, webp)</small>
                <img id="previewFoto" src="uploads/user/default.png" alt="Preview Foto" class="img-thumbnail mt-2" width="250">
              </div>
            </div>
          </div>
        </div>

        <!-- Footer kanan bawah -->
        <div class="card-footer text-right">
          <a href="dashboard.php?hal=user/daftaruser" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
          <button type="reset" class="btn btn-warning btn-sm"><i class="fas fa-retweet"></i> Reset</button>
          <button type="submit" name="aksi" value="tambah" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
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

<!-- Toggle Password -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('togglePassword');
  const input = document.getElementById('password');
  const icon = document.getElementById('toggleIcon');

  btn.addEventListener('click', function () {
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
