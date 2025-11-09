<?php
require_once '../../../includes/ceksession.php';
require_once '../../../includes/koneksi.php';
include '../../../pages/user/header.php';
include '../../../pages/user/navbar.php';
include '../../../pages/user/sidebar.php';

$id = intval($_GET['id']);
$data = $koneksi->query("SELECT * FROM tb_user WHERE iduser=$id")->fetch_assoc();
?>

<div class="container-fluid px-4">
  <h3 class="mt-4 mb-3 border-bottom pb-2">Edit User</h3>

  <?php if ($data): ?>
  <form action="prosesuser.php?aksi=edit" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="iduser" value="<?= $data['iduser']; ?>">

    <div class="mb-3">
      <label>Nama Lengkap</label>
      <input type="text" name="namauser" class="form-control" value="<?= htmlspecialchars($data['namauser']); ?>" required>
    </div>
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" required>
    </div>
    <div class="mb-3">
      <label>Password Baru (kosongkan jika tidak diubah)</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
      <label>Role</label>
      <select name="role" class="form-select">
        <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
        <option value="editor" <?= $data['role'] == 'editor' ? 'selected' : ''; ?>>Editor</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Foto Profil</label><br>
      <?php if ($data['foto']): ?>
        <img src="../../../uploads/user/<?= $data['foto']; ?>" width="60" class="rounded mb-2"><br>
      <?php endif; ?>
      <input type="file" name="foto" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="daftaruser.php" class="btn btn-secondary">Kembali</a>
  </form>
  <?php else: ?>
    <div class="alert alert-warning">Data user tidak ditemukan.</div>
  <?php endif; ?>
</div>

<?php include '../../../pages/user/footer.php'; ?>
