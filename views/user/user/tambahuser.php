<?php
// ==============================================
// File: views/user/user/tambahuser.php
// Deskripsi: Form tambah user CMS Mahdi
// ==============================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Tambah User</h1>
  </section>

  <section class="content">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Form Tambah User</h3>
      </div>

      <form action="views/user/user/prosesuser.php" method="POST" enctype="multipart/form-data">
        <div class="card-body">

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
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
          </div>

          <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
              <option value="">-- Pilih Role --</option>
              <option value="admin">Admin</option>
              <option value="editor">Editor</option>
            </select>
          </div>

          <div class="form-group">
            <label>Foto</label><br>
            <input type="file" name="foto" class="form-control-file" accept=".jpg,.jpeg,.png,.gif,.webp">
            <small class="form-text text-muted">Maksimal 2MB (jpg, png, gif, webp)</small>
            <img id="preview" src="uploads/user/default.png" alt="Preview" class="img-thumbnail mt-2" width="120">
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" name="aksi" value="tambah" class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan
          </button>
          <a href="dashboard.php?hal=user/daftaruser" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </section>
</div>

<script>
document.querySelector('input[name="foto"]').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(evt) {
      document.getElementById('preview').src = evt.target.result;
    };
    reader.readAsDataURL(file);
  }
});
</script>
