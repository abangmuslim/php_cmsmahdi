<?php
require_once '../../includes/konfig.php';
require_once '../../includes/koneksi.php';

include '../../pages/landing/header.php';
include '../../pages/landing/navbar.php';

$id = intval($_GET['id'] ?? 0);
$sql = "SELECT * FROM tb_konten WHERE idkonten=$id AND status='publish'";
$data = $koneksi->query($sql)->fetch_assoc();
?>

<div class="container my-4">
  <?php if ($data): ?>
    <div class="mb-4">
      <h2><?= htmlspecialchars($data['judul']); ?></h2>
      <p class="text-muted">Dipublikasikan pada <?= $data['tanggal']; ?></p>
      <img src="<?= url('uploads/konten/' . $data['gambar']); ?>" class="img-fluid mb-3 rounded" alt="Gambar Artikel">
      <p><?= nl2br($data['isi']); ?></p>
    </div>

    <!-- Form komentar -->
    <div class="card mb-4">
      <div class="card-header">Tulis Komentar</div>
      <div class="card-body">
        <form action="proseskomentar.php" method="POST">
          <input type="hidden" name="idkonten" value="<?= $id; ?>">
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="namakomentator" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Komentar</label>
            <textarea name="isikomentar" class="form-control" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        </form>
      </div>
    </div>

    <!-- Tampilkan komentar -->
    <h5>Komentar:</h5>
    <?php
      $komen = $koneksi->query("SELECT * FROM tb_komentar WHERE idkonten=$id ORDER BY tanggal DESC");
      if ($komen->num_rows > 0):
        while ($k = $komen->fetch_assoc()):
    ?>
        <div class="border p-2 mb-2 rounded bg-light">
          <strong><?= htmlspecialchars($k['namakomentator']); ?></strong><br>
          <small class="text-muted"><?= $k['tanggal']; ?></small>
          <p class="mt-1"><?= nl2br(htmlspecialchars($k['isikomentar'])); ?></p>
        </div>
    <?php endwhile; else: ?>
        <p class="text-muted">Belum ada komentar.</p>
    <?php endif; ?>

  <?php else: ?>
    <div class="alert alert-warning">Konten tidak ditemukan.</div>
  <?php endif; ?>
</div>

<?php include '../../pages/landing/footer.php'; ?>
