<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fas fa-comment"></i> Tambah Komentar</h1>
  </section>

  <section class="content">
    <div class="card card-success">
      <div class="card-header bg-gradient-success">
        <h3 class="card-title"><i class="fas fa-plus-circle"></i> Form Tambah Komentar</h3>
      </div>

      <form action="views/user/komentar/proseskomentar.php" method="POST">
        <div class="card-body">
          <div class="form-group">
            <label>Konten</label>
            <select name="idkonten" class="form-control" required>
              <option value="">-- Pilih Konten --</option>
              <?php
              $res = mysqli_query($koneksi, "SELECT * FROM konten ORDER BY judulkonten ASC");
              while ($row = mysqli_fetch_assoc($res)) {
                  echo "<option value='{$row['idkonten']}'>" . htmlspecialchars($row['judulkonten']) . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>Nama Komentar</label>
            <input type="text" name="namakomentar" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
          </div>

          <div class="form-group">
            <label>Isi Komentar</label>
            <textarea name="isikomentar" class="form-control" rows="5" required></textarea>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="tampil" selected>Tampil</option>
              <option value="sembunyi">Sembunyi</option>
            </select>
          </div>
        </div>

        <div class="card-footer text-right">
          <a href="dashboard.php?hal=komentar/daftarkomentar" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
          <button type="reset" class="btn btn-warning btn-sm"><i class="fas fa-retweet"></i> Reset</button>
          <button type="submit" name="aksi" value="tambah" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </section>
</div>
