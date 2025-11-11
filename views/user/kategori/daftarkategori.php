<?php
// ===============================================
// File: views/user/kategori/daftarkategori.php
// Deskripsi: Daftar Kategori untuk Admin CMS Mahdi (FINAL VERSION)
// ===============================================

// Load keamanan & koneksi
require_once dirname(__DIR__, 3) . '/includes/ceksession.php';
require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
?>

<!-- =============================================== -->
<!--  BAGIAN KONTEN (mengikuti struktur AdminLTE)    -->
<!-- =============================================== -->
<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">

      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="m-0">Daftar Kategori</h5>
          <div class="ml-auto">
            <a href="dashboard.php?hal=kategori/tambahkategori" class="btn btn-info btn-sm text-white fw-bold" style="font-size: 1rem;">
              <i class="fa fa-plus"></i> Tambah Kategori
            </a>
          </div>
        </div>

        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="text-center bg-light">
              <tr>
                <th style="width:5%">No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th style="width:15%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $query = "SELECT * FROM kategori ORDER BY idkategori DESC";
              $hasil = mysqli_query($koneksi, $query);

              while ($data = mysqli_fetch_assoc($hasil)):
              ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td><?= htmlspecialchars($data['namakategori']); ?></td>
                  <td><?= htmlspecialchars($data['deskripsi']); ?></td>
                  <td class="text-center">
                    <!-- Tombol Edit -->
                    <a href="dashboard.php?hal=kategori/editkategori&id=<?= $data['idkategori']; ?>"
                      class="btn btn-warning btn-sm me-1"
                      title="Edit">
                      <i class="fa fa-edit"></i>
                    </a>

                    <!-- Tombol Hapus -->
                    <a href="views/user/kategori/proseskategori.php?aksi=hapus&id=<?= $data['idkategori']; ?>"
                      onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                      class="btn btn-danger btn-sm"
                      title="Hapus">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- =============================================== -->
<!--  STYLE TAMBAHAN KHUSUS UNTUK HALAMAN INI        -->
<!-- =============================================== -->
<style>
  .content-wrapper {
    background-color: #f4f6f9;
    min-height: 100vh;
  }

  @media (max-width: 576px) {
    table th,
    table td {
      font-size: 0.8rem;
    }
  }
</style>
