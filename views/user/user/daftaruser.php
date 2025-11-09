<?php
// ===============================================
// File: views/user/user/daftaruser.php
// Deskripsi: Menampilkan daftar user untuk admin
// ===============================================

require_once '../../../includes/ceksession.php';
require_once '../../../includes/koneksi.php';
include '../../../pages/user/header.php';
include '../../../pages/user/navbar.php';
include '../../../pages/user/sidebar.php';
?>

<div class="container-fluid px-4">
  <h3 class="mt-4 mb-3 border-bottom pb-2">Daftar User</h3>

  <a href="tambahuser.php" class="btn btn-primary mb-3">+ Tambah User</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr class="text-center bg-light">
        <th>No</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Role</th>
        <th>Foto</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $sql = "SELECT * FROM tb_user ORDER BY iduser DESC";
      $hasil = $koneksi->query($sql);

      while ($data = $hasil->fetch_assoc()):
      ?>
        <tr class="align-middle">
          <td class="text-center"><?= $no++; ?></td>
          <td><?= htmlspecialchars($data['namauser']); ?></td>
          <td><?= htmlspecialchars($data['username']); ?></td>
          <td class="text-center"><?= ucfirst($data['role']); ?></td>
          <td class="text-center">
            <?php if ($data['foto']): ?>
              <img src="../../../uploads/user/<?= $data['foto']; ?>" width="40" class="rounded-circle">
            <?php else: ?>
              <span class="text-muted">-</span>
            <?php endif; ?>
          </td>
          <td><?= $data['tanggal']; ?></td>
          <td class="text-center">
            <a href="edituser.php?id=<?= $data['iduser']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="prosesuser.php?aksi=hapus&id=<?= $data['iduser']; ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="btn btn-sm btn-danger">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../../../pages/user/footer.php'; ?>
