<?php
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$idkomentar = intval($_GET['id'] ?? 0);
$res = mysqli_query($koneksi, "SELECT * FROM komentar WHERE idkomentar=$idkomentar");
$data = mysqli_fetch_assoc($res);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan'); window.location='dashboard.php?hal=komentar/daftarkomentar';</script>";
    exit;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fas fa-edit"></i> Edit Komentar</h1>
  </section>

  <section class="content">
    <div class="card card-warning">
      <div class="card-header bg-gradient-warning">
        <h3 class="card-title"><i class="fas fa-edit"></i> Form Edit Komentar</h3>
      </div>

      <form action="views/user/komentar/proseskomentar.php" method="POST">
        <input type="hidden" name="idkomentar" value="<?= $idkomentar; ?>">

        <div class="card-body">
          <div class="form-group">
            <label>Konten</label>
            <select name="idkonten" class="form-control" required>
              <?php
              $resKonten = mysqli_query($koneksi, "SELECT * FROM konten ORDER BY judulkonten ASC");
              while ($row = mysqli_fetch_assoc($resKonten)) {
                  $sel = ($row['idkonten'] == $data['idkonten']) ? 'selected' : '';
                  echo "<option value='{$row['idkonten']}' $sel>" . htmlspecialchars($row['judulkonten']) . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>Nama Komentar</label>
            <input type="text" name="namakomentar" class="form-control" value="<?= htmlspecialchars($data['namakomentar']); ?>" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']); ?>">
          </div>

          <div class="form-group">
            <label>Isi Komentar</label>
            <textarea name="isikomentar" class="form-control" rows="5" required><?= htmlspecialchars($data['isikomentar']); ?></textarea>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="tampil" <?= $data['status']=='tampil'?'selected':''; ?>>Tampil</option>
              <option value="sembunyi" <?= $data['status']=='sembunyi'?'selected':''; ?>>Sembunyi</option>
            </select>
          </div>
        </div>

        <div class="card-footer text-right">
          <a href="dashboard.php?hal=komentar/daftarkomentar" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
          <button type="reset" class="btn btn-warning btn-sm"><i class="fas fa-retweet"></i> Reset</button>
          <button type="submit" name="aksi" value="update" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </section>
</div>
