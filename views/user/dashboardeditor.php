<?php
include '../../includes/ceksession.php';
include '../../includes/koneksi.php';
include '../../pages/editor/header.php';
include '../../pages/editor/navbar.php';
include '../../pages/editor/sidebar.php';

// ambil data untuk statistik
$total_konten   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM konten"))['jml'];
$total_komentar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM komentar"))['jml'];

// ambil data ringkas konten dan komentar
$qkonten = mysqli_query($conn, "SELECT judulkonten, tanggal FROM konten ORDER BY tanggal DESC LIMIT 5");
$qkomentar = mysqli_query($conn, "SELECT nama, isikomentar, tanggal FROM komentar ORDER BY tanggal DESC LIMIT 5");
?>

<!-- Content Wrapper -->
<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">

      <!-- Statistik Ringkas -->
      <div class="row">
        <div class="col-md-6 col-sm-12 mb-3">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $total_konten ?></h3>
              <p>Total Konten</p>
            </div>
            <div class="icon">
              <i class="fas fa-newspaper"></i>
            </div>
            <a href="?page=konten/daftarkonten" class="small-box-footer">
              Lihat Konten <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-md-6 col-sm-12 mb-3">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $total_komentar ?></h3>
              <p>Total Komentar</p>
            </div>
            <div class="icon">
              <i class="fas fa-comments"></i>
            </div>
            <a href="?page=komentar/daftarkomentar" class="small-box-footer">
              Lihat Komentar <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Ringkasan Data -->
      <div class="row">
        <!-- Konten Terbaru -->
        <div class="col-lg-6 col-12 mb-3">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h6 class="m-0">Konten Terbaru</h6>
            </div>
            <div class="card-body p-2">
              <table class="table table-sm table-striped mb-0">
                <thead>
                  <tr>
                    <th>Judul</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($k = mysqli_fetch_assoc($qkonten)) { ?>
                    <tr>
                      <td><?= htmlspecialchars($k['judulkonten']) ?></td>
                      <td><?= date('d/m/Y', strtotime($k['tanggal'])) ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Komentar Terbaru -->
        <div class="col-lg-6 col-12">
          <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
              <h6 class="m-0">Komentar Terbaru</h6>
            </div>
            <div class="card-body p-2">
              <table class="table table-sm table-striped mb-0">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($c = mysqli_fetch_assoc($qkomentar)) { ?>
                    <tr>
                      <td><?= htmlspecialchars($c['nama']) ?></td>
                      <td><?= htmlspecialchars(substr($c['isikomentar'], 0, 40)) ?>...</td>
                      <td><?= date('d/m/Y', strtotime($c['tanggal'])) ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<style>
@media (max-width: 576px) {
  .small-box .inner h3 { font-size: 1.5rem; }
  .small-box p { font-size: 0.9rem; }
  .card-header h6 { font-size: 0.9rem; }
  table th, table td { font-size: 0.8rem; }
}
</style>

<?php include '../../pages/editor/footer.php'; ?>
