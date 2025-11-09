<?php
// ===============================================
// File: views/user/kategori/editkategori.php
// Deskripsi: Form edit data kategori
// ===============================================

require_once '../../../includes/ceksession.php';
require_once '../../../includes/koneksi.php';
include '../../../pages/user/header.php';
include '../../../pages/user/navbar.php';
include '../../../pages/user/sidebar.php';

$id = intval($_GET['id']);
$data = $koneksi->query("SELECT * FROM tb_kategori WHERE idkategori=$id")->fetch_assoc();
?>

<div class="container-fluid px-4">
  <h3 class="mt-4 mb-3 border-bottom pb-2">Edit Kategori</h3>

  <?php if ($data): ?>
  <form action="proseskategori.php?aksi=edit" method="POST">
    <input type="hidden" name="idkategori" value="<?= $data['idkategori']; ?>">

    <div class="mb-3">
      <label>Nama Kategori</label>
      <input type="text" name="namakategori" class="form-control" value="<?= htmlspecialchars($data['namakategori']); ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="daftarkategori.php" class="btn btn-secondary">Kembali</a>
  </form>
  <?php else: ?>
    <div class="alert alert-warning">Data kategori tidak ditemukan.</div>
  <?php endif; ?>
</div>

<?php include '../../../pages/user/footer.php'; ?>
