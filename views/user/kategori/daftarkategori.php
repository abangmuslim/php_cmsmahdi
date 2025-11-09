<?php
// ===============================================
// File: views/user/kategori/daftarkategori.php
// Deskripsi: Menampilkan daftar kategori
// ===============================================

require_once '../../../includes/ceksession.php';
require_once '../../../includes/koneksi.php';
include '../../../pages/user/header.php';
include '../../../pages/user/navbar.php';
include '../../../pages/user/sidebar.php';
?>

<div class="container-fluid px-4">
  <h3 class="mt-4 mb-3 border-bottom pb-2">Daftar Kategori</h3>

  <a href="tambahkategori.php" class="btn btn-primary mb-3">+ Tambah Kategori</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr class="text-center bg-light">
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Slug</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $sql = "SELECT * FROM tb_kategori ORDER BY idkategori DESC";
      $hasil = $koneksi->query($sql);

      while ($data = $hasil->fetch_assoc()):
      ?>
        <tr>
          <td class="text-center"><?= $no++; ?></td>
          <td><?= htmlspecialchars($data['namakategori']); ?></td>
          <td><?= htmlspecialchars($data['slug']); ?></td>
          <td><?= $data['tanggal']; ?></td>
          <td class="text-center">
            <a href="editkategori.php?id=<?= $data['idkategori']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="proseskategori.php?aksi=hapus&id=<?= $data['idkategori']; ?>" onclick="return confirm('Yakin ingin menghapus kategori ini?')" class="btn btn-sm btn-danger">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../../../pages/user/footer.php'; ?>
