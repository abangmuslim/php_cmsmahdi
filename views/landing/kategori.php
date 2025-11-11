<?php
// ===============================================
// File: views/landing/kategori.php
// Deskripsi: Halaman daftar konten per kategori atau tag, atau daftar kategori
// ===============================================

require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Ambil parameter 'id' dari URL
$idkat = $_GET['id'] ?? null;
$is_tag = false;

// Tentukan apakah filter berdasarkan kategori atau tag
if ($idkat !== null && !is_numeric($idkat)) {
    $is_tag = true;
    $tag_param = trim($idkat);
} elseif ($idkat !== null) {
    $idkat = intval($idkat);
}
?>

<div class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-4">
      <div class="row">
        <!-- Kolom utama -->
        <div class="col-md-8">

<?php if ($idkat || $is_tag): ?>

    <?php if ($is_tag): ?>
        <h3 class="mb-3 border-bottom pb-2">Tag: <?= htmlspecialchars($tag_param); ?></h3>

        <?php
        $stmt = $koneksi->prepare("
            SELECT * FROM konten 
            WHERE FIND_IN_SET(?, tag) > 0 AND status='publik'
            ORDER BY tanggalbuat DESC
        ");
        $stmt->bind_param("s", $tag_param);
        $stmt->execute();
        $hasil = $stmt->get_result();
        ?>

        <?php if ($hasil->num_rows > 0): ?>
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
                        <h5 class="card-title"><?= htmlspecialchars($data['judulkonten']); ?></h5>
                        <p class="card-text"><?= substr(strip_tags($data['isikonten']), 0, 150); ?>...</p>
                        <a href="<?= url('detilkonten?id=' . $data['idkonten']); ?>" class="btn btn-sm btn-outline-primary">
                          Baca Selengkapnya
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada artikel dengan tag ini.</p>
        <?php endif; ?>
        <?php $stmt->close(); ?>

    <?php else: // filter kategori ?>
        <?php
        $stmt = $koneksi->prepare("SELECT * FROM kategori WHERE idkategori = ?");
        $stmt->bind_param("i", $idkat);
        $stmt->execute();
        $result = $stmt->get_result();
        $kategori = $result->fetch_assoc();
        $stmt->close();
        ?>

        <h3 class="mb-3 border-bottom pb-2">Kategori: <?= htmlspecialchars($kategori['namakategori'] ?? 'Tidak Ditemukan'); ?></h3>

        <?php if ($kategori): ?>
            <?php
            $stmt = $koneksi->prepare("
                SELECT * FROM konten 
                WHERE idkategori = ? AND status='publik'
                ORDER BY tanggalbuat DESC
            ");
            $stmt->bind_param("i", $idkat);
            $stmt->execute();
            $hasil = $stmt->get_result();
            ?>
            <?php if ($hasil->num_rows > 0): ?>
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
                            <h5 class="card-title"><?= htmlspecialchars($data['judulkonten']); ?></h5>
                            <p class="card-text"><?= substr(strip_tags($data['isikonten']), 0, 150); ?>...</p>
                            <a href="<?= url('detilkonten?id=' . $data['idkonten']); ?>" class="btn btn-sm btn-outline-primary">
                              Baca Selengkapnya
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada artikel di kategori ini.</p>
            <?php endif; ?>
            <?php $stmt->close(); ?>
        <?php else: ?>
            <p class="text-muted">Kategori tidak ditemukan.</p>
        <?php endif; ?>
    <?php endif; ?>

<?php else: // tampilkan daftar semua kategori ?>
    <h3 class="mb-3 border-bottom pb-2">Daftar Kategori</h3>

    <?php
    $hasil = $koneksi->query("SELECT * FROM kategori ORDER BY idkategori ASC");
    if ($hasil && $hasil->num_rows > 0):
    ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th width="50">No</th>
              <th>Nama Kategori</th>
              <th>Deskripsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; while ($row = $hasil->fetch_assoc()): ?>
              <tr>
                <td><?= $no++; ?></td>
                <td>
                  <a href="<?= url('kategori?id=' . $row['idkategori']); ?>">
                    <?= htmlspecialchars($row['namakategori']); ?>
                  </a>
                </td>
                <td><?= htmlspecialchars($row['deskripsi']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
        <p class="text-muted">Belum ada kategori tersedia.</p>
    <?php endif; ?>

<?php endif; // akhir if utama ?>

        </div>

        <!-- Sidebar kanan -->
        <div class="col-md-4">
          <?php include PAGES_PATH . 'landing/sidebar-right.php'; ?>
        </div>

      </div>
    </div>
  </main>
</div>
