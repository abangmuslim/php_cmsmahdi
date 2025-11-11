<?php
// ==============================================
// File: views/user/konten/editkonten.php
// ==============================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

$idkonten = intval($_GET['id'] ?? 0);
$res = mysqli_query($koneksi, "SELECT * FROM konten WHERE idkonten=$idkonten");
$data = mysqli_fetch_assoc($res);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan'); window.location='dashboard.php?hal=konten/daftarkonten';</script>";
    exit;
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fas fa-edit"></i> Edit Konten</h1>
  </section>

  <section class="content">
    <div class="card card-warning">
      <div class="card-header bg-gradient-warning">
        <h3 class="card-title"><i class="fas fa-edit"></i> Form Edit Konten</h3>
      </div>

      <form action="views/user/konten/proseskonten.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idkonten" value="<?= $idkonten; ?>">

        <div class="card-body">
          <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-8">
              <div class="form-group">
                <label>Judul Konten</label>
                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judulkonten']); ?>" required>
              </div>

              <div class="form-group">
                <label>Isi Konten</label>
                <textarea name="isi" class="form-control summernote" rows="10" required><?= htmlspecialchars($data['isikonten']); ?></textarea>
              </div>

              <div class="form-group">
                <label>Kategori</label>
                <select name="idkategori" class="form-control" required>
                  <?php
                  $resKat = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY namakategori ASC");
                  while ($row = mysqli_fetch_assoc($resKat)) {
                      $sel = ($row['idkategori'] == $data['idkategori']) ? 'selected' : '';
                      echo "<option value='{$row['idkategori']}' $sel>" . htmlspecialchars($row['namakategori']) . "</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label>Tag (pisahkan dengan koma)</label>
                <input type="text" name="tag" class="form-control" value="<?= htmlspecialchars($data['tag'] ?? ''); ?>">
              </div>

              <div class="form-group mt-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                  <option value="draft" <?= $data['status']=='draft'?'selected':''; ?>>Draft</option>
                  <option value="publik" <?= $data['status']=='publik'?'selected':''; ?>>Publik</option>
                </select>
              </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-4 text-center">
              <div class="form-group">
                <label>Gambar Konten</label><br>
                <input type="file" name="gambar" id="gambarInput" class="form-control-file" accept=".jpg,.jpeg,.png,.gif,.webp">
                <small class="form-text text-muted">Maks 2MB</small>
                <img id="previewGambar" src="uploads/konten/<?= !empty($data['gambar'])?$data['gambar']:'default.png'; ?>" class="img-thumbnail mt-2" width="250">
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer text-right">
          <a href="dashboard.php?hal=konten/daftarkonten" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
          <button type="reset" class="btn btn-warning btn-sm"><i class="fas fa-retweet"></i> Reset</button>
          <button type="submit" name="aksi" value="update" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </section>
</div>

<script>
document.getElementById('gambarInput').addEventListener('change', function(e){
  const file = e.target.files[0];
  if(file){
    const reader = new FileReader();
    reader.onload = function(ev){
      document.getElementById('previewGambar').src = ev.target.result;
    }
    reader.readAsDataURL(file);
  }
});
</script>
<script>
$(document).ready(function() {
  $('.summernote').summernote({
    height: 250
  });
});
</script>
