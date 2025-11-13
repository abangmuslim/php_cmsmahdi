<?php
// ===============================================
// File: views/user/kategori/daftarkategori.php
// Deskripsi: Daftar & Tambah Kategori (2 kolom layout) CMS Mahdi
// ===============================================

require_once dirname(__DIR__, 3) . '/includes/ceksession.php';
require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
?>

<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- ================== KOLOM KIRI (FORM TAMBAH) ================== -->
        <div class="col-md-4">
          <div class="card card-success">
            <div class="card-header bg-gradient-success">
              <h3 class="card-title"><i class="fas fa-plus-circle"></i> Form Tambah Kategori</h3>
            </div>

            <form action="views/user/kategori/proseskategori.php" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label>Nama Kategori</label>
                  <input type="text" name="namakategori" class="form-control" placeholder="Masukkan nama kategori" required>
                </div>

                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi kategori (opsional)"></textarea>
                </div>
              </div>

              <div class="card-footer text-right">
                <button type="reset" class="btn btn-warning btn-sm">
                  <i class="fas fa-retweet"></i> Reset
                </button>

                <button type="submit" name="aksi" value="tambah" class="btn btn-primary btn-sm">
                  <i class="fas fa-save"></i> Simpan
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- ================== KOLOM KANAN (DAFTAR KATEGORI) ================== -->
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h5 class="m-0">Daftar Kategori</h5>
              <div class="ml-auto">
                <a href="dashboard.php?hal=kategori/daftarkategori" class="btn btn-light btn-sm text-primary fw-bold" style="font-size: 1rem;">
                  <i class="fa fa-sync"></i> Refresh
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

                  while ($data = mysqli_fetch_assoc($hasil)): ?>
                    <tr>
                      <td class="text-center"><?= $no++; ?></td>
                      <td><?= htmlspecialchars($data['namakategori']); ?></td>
                      <td><?= htmlspecialchars($data['deskripsi']); ?></td>
                      <td class="text-center">
                        <a href="dashboard.php?hal=kategori/editkategori&id=<?= $data['idkategori']; ?>" class="btn btn-warning btn-sm me-1" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
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
        <!-- ================== END KOLOM ================== -->
      </div>
    </div>
  </section>
</div>

<style>
  .content-wrapper {
    background-color: #f4f6f9;
    min-height: 100vh;
  }

  .card {
    border-radius: 0.5rem;
  }

  .card-title {
    font-weight: bold;
  }

  @media (max-width: 768px) {
    .col-md-4, .col-md-8 {
      flex: 100%;
      max-width: 100%;
    }

    table th, table td {
      font-size: 0.85rem;
    }
  }
</style>
