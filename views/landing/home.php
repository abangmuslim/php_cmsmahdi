<?php
// ===============================================
// File: views/landing/home.php
// Deskripsi: Halaman utama portal CMSMAHDI
// ===============================================

// Ambil 10 konten terbaru beserta kategori & penulis
$query = "
  SELECT k.*, 
         kat.namakategori, 
         u.namauser
  FROM konten k
  LEFT JOIN kategori kat ON k.idkategori = kat.idkategori
  LEFT JOIN user u ON k.iduser = u.iduser
  WHERE k.status = 'publik'
  ORDER BY k.tanggalbuat DESC
  LIMIT 10
";
$hasil = $koneksi->query($query);
?>

<div class="container my-4">
  <div class="row">

    <!-- Konten utama -->
    <div class="col-md-8">
      <h3 class="mb-3 border-bottom pb-2">Berita Terbaru</h3>

      <?php if ($hasil && $hasil->num_rows > 0): ?>
        <?php while ($data = $hasil->fetch_assoc()): ?>

          <div class="card mb-3 shadow-sm">
            <div class="row g-0">

              <?php if (!empty($data['gambar'])): ?>
                <div class="col-md-4">
                  <img src="<?= url('uploads/konten/' . $data['gambar']); ?>"
                       class="img-fluid rounded-start"
                       alt="<?= htmlspecialchars($data['judulkonten']); ?>">
                </div>
              <?php endif; ?>

              <div class="col-md-8">
                <div class="card-body">

                  <!-- Judul -->
                  <h5 class="card-title mb-1">
                    <?= htmlspecialchars($data['judulkonten']); ?>
                  </h5>

                  <!-- Meta info -->
                  <p class="text-muted small mb-2">
                    <?php if (!empty($data['namakategori'])): ?>
                      [<a href="<?= url('kategori?id=' . $data['idkategori']); ?>" class="text-decoration-none text-primary">
                        <?= htmlspecialchars($data['namakategori']); ?>
                      </a>]
                    <?php endif; ?>

                    <?php if (!empty($data['namauser'])): ?>
                      [<?= htmlspecialchars($data['namauser']); ?>]
                    <?php endif; ?>

                    [<?= date('d M Y', strtotime($data['tanggalbuat'])); ?>]
                  </p>

                  <!-- Cuplikan isi -->
                  <p class="card-text mb-3">
                    <?= substr(strip_tags($data['isikonten']), 0, 120); ?>...
                  </p>

                  <!-- Tombol baca -->
                  <?php
                  // Versi stabil tanpa slug
                  $url_detil = url('artikel/' . $data['idkonten']);
                  ?>
                  <a href="<?= $url_detil; ?>" class="btn btn-sm btn-primary">
                    Baca Selengkapnya
                  </a>

                </div>
              </div>

            </div>
          </div>

        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-muted">Belum ada artikel yang dipublikasikan.</p>
      <?php endif; ?>
    </div>

    <!-- Sidebar kanan -->
    <div class="col-md-4">
      <?php include PAGES_PATH . 'landing/sidebar-right.php'; ?>
    </div>

  </div>
</div>
