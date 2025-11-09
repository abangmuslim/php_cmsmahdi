<?php
// ===============================================
// File: views/landing/kategori.php
// Deskripsi: Halaman daftar konten per kategori di CMSMAHDI
// ===============================================

require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

include PAGES_PATH . 'landing/header.php';
include PAGES_PATH . 'landing/navbar.php';

// Ambil ID kategori dari URL (aman)
$idkat = isset($_GET['id']) ? intval($_GET['id']) : 0;
$kategori = null;

// Ambil data kategori jika ada
if ($idkat > 0) {
    $stmt = $koneksi->prepare("SELECT * FROM tb_kategori WHERE idkategori = ?");
    $stmt->bind_param("i", $idkat);
    $stmt->execute();
    $result = $stmt->get_result();
    $kategori = $result->fetch_assoc();
    $stmt->close();
}
?>

<div class="container my-4">
  <h3 class="border-bottom pb-2 mb-3">
    Kategori: <?= htmlspecialchars($kategori['namakategori'] ?? 'Tidak Ditemukan'); ?>
  </h3>

  <div class="row">
    <div class="col-md-8">
      <?php
      if ($idkat > 0 && $kategori) {
          $stmt = $koneksi->prepare("
              SELECT * FROM tb_konten 
              WHERE idkategori = ? AND status = 'publish' 
              ORDER BY tanggal DESC
          ");
          $stmt->bind_param("i", $idkat);
          $stmt->execute();
          $hasil = $stmt->get_result();

          if ($hasil->num_rows > 0):
              while ($data = $hasil->fetch_assoc()):
      ?>
                <div class="card mb-3 shadow-sm">
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($data['judul']); ?></h5>
                    <p class="card-text"><?= substr(strip_tags($data['isi']), 0, 150); ?>...</p>
                    <a href="detilkonten.php?id=<?= $data['idkonten']; ?>" class="btn btn-sm btn-outline-primary">
                      Baca Selengkapnya
                    </a>
                  </div>
                </div>
      <?php
              endwhile;
          else:
              echo "<p class='text-muted'>Belum ada artikel di kategori ini.</p>";
          endif;

          $stmt->close();
      } else {
          echo "<p class='text-muted'>Kategori tidak ditemukan.</p>";
      }
      ?>
    </div>

    <!-- Sidebar kanan -->
    <div class="col-md-4">
      <?php include PAGES_PATH . 'landing/sidebar-right.php'; ?>
    </div>
  </div>
</div>

<?php include PAGES_PATH . 'landing/footer.php'; ?>
