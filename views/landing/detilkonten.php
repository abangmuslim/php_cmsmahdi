<?php
// ===============================================
// File: views/landing/detilkonten.php
// Deskripsi: Halaman detil artikel publik
// ===============================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Ambil ID konten dari URL
$id = intval($_GET['id'] ?? 0);

// Ambil data konten beserta kategori & penulis
$sql = "
  SELECT k.*, 
         kat.namakategori, 
         u.namauser
  FROM konten k
  LEFT JOIN kategori kat ON k.idkategori = kat.idkategori
  LEFT JOIN user u ON k.iduser = u.iduser
  WHERE k.idkonten = $id AND k.status = 'publik'
";
$result = $koneksi->query($sql);
$data = $result ? $result->fetch_assoc() : null;
?>

<div class="container my-4">
  <?php if ($data): ?>
    <div class="mb-4">
      <!-- Judul -->
      <h2><?= htmlspecialchars($data['judulkonten']); ?></h2>

      <!-- Info meta -->
      <p class="text-muted mb-2">
        Dipublikasikan pada <?= htmlspecialchars(date('d M Y', strtotime($data['tanggalbuat']))); ?> 
        <?php if (!empty($data['namakategori'])): ?>
          • Kategori: 
          <a href="<?= url('kategori?id=' . $data['idkategori']); ?>" class="text-decoration-none">
            <?= htmlspecialchars($data['namakategori']); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($data['namauser'])): ?>
          • Penulis: <strong><?= htmlspecialchars($data['namauser']); ?></strong>
        <?php endif; ?>
      </p>

      <!-- Gambar -->
      <?php if (!empty($data['gambar'])): ?>
        <img src="<?= url('uploads/konten/' . $data['gambar']); ?>" 
             class="img-fluid mb-3 rounded" 
             alt="<?= htmlspecialchars($data['judulkonten']); ?>">
      <?php endif; ?>

      <!-- Isi konten -->
      <p><?= nl2br(htmlspecialchars($data['isikonten'])); ?></p>
    </div>

    <!-- Form komentar -->
    <div class="card mb-4">
      <div class="card-header">Tulis Komentar</div>
      <div class="card-body">
        <form action="<?= url('views/landing/proseskomentar.php'); ?>" method="POST">
          <input type="hidden" name="idkonten" value="<?= $id; ?>">
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="namakomentar" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Komentar</label>
            <textarea name="isikomentar" class="form-control" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Kirim Komentar</button>
        </form>
      </div>
    </div>

    <!-- Daftar komentar -->
    <h5 class="mt-4">Komentar:</h5>
    <?php
      $komen = $koneksi->query("
        SELECT * FROM komentar 
        WHERE idkonten = $id AND status = 'tampil' 
        ORDER BY tanggalbuat DESC
      ");
      if ($komen && $komen->num_rows > 0):
        while ($k = $komen->fetch_assoc()):
    ?>
        <div class="border p-3 mb-2 rounded bg-light">
          <strong><?= htmlspecialchars($k['namakomentar']); ?></strong><br>
          <small class="text-muted"><?= date('d M Y H:i', strtotime($k['tanggalbuat'])); ?></small>
          <p class="mt-2"><?= nl2br(htmlspecialchars($k['isikomentar'])); ?></p>
        </div>
    <?php endwhile; else: ?>
        <p class="text-muted">Belum ada komentar.</p>
    <?php endif; ?>

  <?php else: ?>
    <div class="alert alert-warning">Konten tidak ditemukan.</div>
  <?php endif; ?>
</div>
