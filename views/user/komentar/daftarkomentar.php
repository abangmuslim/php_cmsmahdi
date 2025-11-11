<?php
// ==============================================
// File: views/user/komentar/daftarkomentar.php
// ==============================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<div class="content-wrapper p-3">
  <section class="content">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="m-0">Daftar Komentar</h5>
        <div class="ml-auto">
          <a href="dashboard.php?hal=komentar/tambahkomentar" class="btn btn-info btn-sm text-white fw-bold">
            <i class="fa fa-plus"></i> Tambah Komentar
          </a>
        </div>
      </div>

      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
          <thead class="text-center bg-light">
            <tr>
              <th style="width:5%">No</th>
              <th>Konten</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Isi Komentar</th>
              <th>Status</th>
              <th style="width:15%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $query = "SELECT c.*, k.judulkonten FROM komentar c LEFT JOIN konten k ON c.idkonten=k.idkonten ORDER BY c.idkomentar DESC";
            $hasil = mysqli_query($koneksi, $query);
            while ($row = mysqli_fetch_assoc($hasil)):
            ?>
              <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['judulkonten'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($row['namakomentar']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['isikomentar']); ?></td>
                <td class="text-center"><?= $row['status']; ?></td>
                <td class="text-center">
                  <a href="dashboard.php?hal=komentar/editkomentar&id=<?= $row['idkomentar']; ?>" class="btn btn-warning btn-sm me-1" title="Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="views/user/komentar/proseskomentar.php?aksi=hapus&id=<?= $row['idkomentar']; ?>" onclick="return confirm('Yakin ingin menghapus komentar ini?')" class="btn btn-danger btn-sm" title="Hapus">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
