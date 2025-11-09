<?php
// ===============================================
// File: views/landing/kategori.php
// Deskripsi: Halaman daftar konten per kategori, atau daftar kategori
// ===============================================

require_once $_SERVER['DOCUMENT_ROOT'] . '/cmsmahdi/includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

// Ambil ID kategori dari URL (aman)
$idkat = isset($_GET['id']) ? intval($_GET['id']) : 0;
$kategori = null;
?>

<!-- Wrapper agar footer selalu di bawah -->
<div class="d-flex flex-column min-vh-100">
  <main class="flex-fill">
    <div class="container my-4">
      <div class="row">

        <!-- Kolom utama -->
        <div class="col-md-8">

          <?php if ($idkat > 0): ?>
            <?php
            // Ambil data kategori spesifik
            $stmt = $koneksi->prepare("SELECT * FROM kategori WHERE idkategori = ?");
            $stmt->bind_param("i", $idkat);
            $stmt->execute();
            $result = $stmt->get_result();
            $kategori = $result->fetch_assoc();
            $stmt->close();
            ?>

            <h3 class="mb-3 border-bottom pb-2">
              Kategori: <?= htmlspecialchars($kategori['namakategori'] ?? 'Tidak Ditemukan'); ?>
            </h3>

            <?php
            if ($kategori) {
                $stmt = $koneksi->prepare("
                    SELECT * FROM konten 
                    WHERE idkategori = ? AND status = 'publik' 
                    ORDER BY tanggalbuat DESC
                ");
                $stmt->bind_param("i", $idkat);
                $stmt->execute();
                $hasil = $stmt->get_result();

                if ($hasil->num_rows > 0):
                    while ($data = $hasil->fetch_assoc()):
            ?>
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

          <?php else: ?>
            <!-- Jika tidak ada ID kategori, tampilkan daftar semua kategori -->
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
            <?php
            else:
                echo "<p class='text-muted'>Belum ada kategori tersedia.</p>";
            endif;
            ?>
          <?php endif; ?>

        </div>

        <!-- Sidebar kanan -->
        <div class="col-md-4">
          <?php include PAGES_PATH . 'landing/sidebar-right.php'; ?>
        </div>

      </div>
    </div>
  </main>
</div>
