<?php
// ===============================================
// File: views/user/kategori/tambahkategori.php
// Deskripsi: Form tambah kategori baru
// ===============================================

require_once '../../../includes/ceksession.php';
include '../../../pages/user/header.php';
include '../../../pages/user/navbar.php';
include '../../../pages/user/sidebar.php';
?>

<div class="container-fluid px-4">
  <h3 class="mt-4 mb-3 border-bottom pb-2">Tambah Kategori</h3>

  <form action="proseskategori.php?aksi=tambah" method="POST">
    <div class="mb-3">
      <label>Nama Kategori</label>
      <input type="text" name="namakategori" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="daftarkategori.php" class="btn btn-secondary">Batal</a>
  </form>
</div>

<?php include '../../../pages/user/footer.php'; ?>
