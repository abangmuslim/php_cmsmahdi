<?php
// ==============================================
// File: views/user/kategori/editkategori.php
// Deskripsi: Form edit kategori CMS Mahdi
// ==============================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil id kategori dari GET
$id = intval($_GET['id'] ?? 0);

// Ambil data kategori
$stmt = $koneksi->prepare("SELECT * FROM kategori WHERE idkategori=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data) {
  echo "<script>alert('Kategori tidak ditemukan'); window.location='dashboard.php?hal=user/daftarkategori';</script>";
  exit;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fas fa-edit"></i> Edit Kategori</h1>
  </section>

  <section class="content">
    <div class="card card-warning">
      <div class="card-header bg-gradient-warning">
        <h3 class="card-title"><i class="fas fa-edit"></i> Form Edit Kategori</h3>
      </div>

      <form action="views/user/kategori/proseskategori.php" method="POST">
        <input type="hidden" name="idkategori" value="<?= $data['idkategori']; ?>">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="namakategori" class="form-control" value="<?= htmlspecialchars($data['namakategori']); ?>" required>
              </div>

              <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
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
          <button type="submit" name="aksi" value="update"
            class="btn btn-primary btn-sm">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>

      </form>
    </div>
  </section>
</div>