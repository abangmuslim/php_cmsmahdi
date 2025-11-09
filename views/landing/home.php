<?php
// ===============================================
// File: views/landing/home.php
// Deskripsi: Halaman utama portal CMSMAHDI
// ===============================================

// Muat definisi path
require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';

// Include konfigurasi dan koneksi database
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Layout atas
include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';
?>

<div class="container my-4">
  <div class="row">

    <!-- Konten utama -->
    <div class="col-md-8">
      <h3 class="mb-3 border-bottom pb-2">Berita Terbaru</h3>

      <?php
      // Ambil 10 konten terbaru yang status 'publik'
      $query = "SELECT * FROM konten WHERE status='publik' ORDER BY tanggalbuat DESC LIMIT 10";
      $hasil = $koneksi->query($query);

      if ($hasil && $hasil->num_rows > 0):
        while ($data = $hasil->fetch_assoc()):
      ?>
        <div class="card mb-3 shadow-sm">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="<?= url('uploads/konten/' . $data['gambar']); ?>" 
                   class="img-fluid rounded-start" 
                   alt="<?= htmlspecialchars($data['judulkonten']); ?>">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($data['judulkonten']); ?></h5>
                <p class="card-text"><?= substr(strip_tags($data['isikonten']), 0, 120); ?>...</p>
                <a href="detilkonten.php?id=<?= $data['idkonten']; ?>" 
                   class="btn btn-sm btn-primary">Baca Selengkapnya</a>
              </div>
            </div>
          </div>
        </div>
      <?php
        endwhile;
      else:
        echo "<p class='text-muted'>Belum ada artikel yang dipublikasikan.</p>";
      endif;
      ?>
    </div>

    <!-- Sidebar kanan -->
    <div class="col-md-4">
      <?php include PAGES_PATH . 'landing/sidebar-right.php'; ?>
    </div>

  </div>
</div>

<?php include PAGES_PATH . 'landing/footer.php'; ?>
