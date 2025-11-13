<?php
// ==============================================
// File: views/user/kategori/tambahkategori.php
// Deskripsi: Form tambah kategori CMS Mahdi
// ==============================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fas fa-folder-plus"></i> Tambah Kategori</h1>
  </section>

  <section class="content">
    <div class="card card-success">
      <div class="card-header bg-gradient-success">
        <h3 class="card-title"><i class="fas fa-plus-circle"></i> Form Tambah Kategori</h3>
      </div>

      <form action="views/user/kategori/proseskategori.php" method="POST">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="namakategori" class="form-control" placeholder="Masukkan nama kategori" required>
              </div>

              <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi kategori (opsional)"></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer kanan bawah -->
        <div class="card-footer text-right">
          <!-- Tombol Kembali -->
          <a href="dashboard.php?hal=kategori/daftarkategori"
            class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>

          <!-- Tombol Reset -->
          <button type="reset" class="btn btn-warning btn-sm">
            <i class="fas fa-retweet"></i> Reset
          </button>

          <!-- Tombol Simpan -->
          <button type="submit" name="aksi" value="tambah"
            class="btn btn-primary btn-sm">
            <i class="fas fa-save"></i> Simpan
          </button>

        </div>
      </form>
    </div>
  </section>
</div>