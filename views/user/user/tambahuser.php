<?php
require_once '../../../includes/ceksession.php';
include '../../../pages/user/header.php';
include '../../../pages/user/navbar.php';
include '../../../pages/user/sidebar.php';
?>

<div class="container-fluid px-4">
  <h3 class="mt-4 mb-3 border-bottom pb-2">Tambah User</h3>

  <form action="prosesuser.php?aksi=tambah" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Nama Lengkap</label>
      <input type="text" name="namauser" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Role</label>
      <select name="role" class="form-select" required>
        <option value="admin">Admin</option>
        <option value="editor">Editor</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Foto Profil (opsional)</label>
      <input type="file" name="foto" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="daftaruser.php" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?php include '../../../pages/user/footer.php'; ?>
