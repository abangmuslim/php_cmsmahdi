<?php
include '../../includes/ceksession.php';
include '../../includes/koneksi.php';
include '../../pages/user/header.php';
include '../../pages/user/navbar.php';
include '../../pages/user/sidebar.php';

// ambil data untuk statistik
$total_user     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM user"))['jml'];
$total_konten   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM konten"))['jml'];
$total_kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM kategori"))['jml'];
$total_komentar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM komentar"))['jml'];

// data untuk grafik konten per kategori
$qkategori = mysqli_query($conn, "
  SELECT k.namakategori, COUNT(c.idkonten) as jumlah 
  FROM kategori k LEFT JOIN konten c ON c.idkategori = k.idkategori
  GROUP BY k.idkategori
");
$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($qkategori)) {
  $labels[] = $row['namakategori'];
  $data[] = $row['jumlah'];
}

// konten & komentar terbaru
$qkonten = mysqli_query($conn, "SELECT idkonten, judulkonten, tanggal FROM konten ORDER BY tanggal DESC LIMIT 5");
$qkomentar = mysqli_query($conn, "SELECT nama, isikomentar, tanggal FROM komentar ORDER BY tanggal DESC LIMIT 5");
?>

<!-- Content Wrapper -->
<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">

      <!-- Statistik Ringkas -->
      <div class="row">
        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $total_user ?></h3>
              <p>Total User</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="?page=user/daftaruser" class="small-box-footer">
              Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $total_konten ?></h3>
              <p>Total Konten</p>
            </div>
            <div class="icon">
              <i class="fas fa-newspaper"></i>
            </div>
            <a href="?page=konten/daftarkonten" class="small-box-footer">
              Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $total_kategori ?></h3>
              <p>Total Kategori</p>
            </div>
            <div class="icon">
              <i class="fas fa-list"></i>
            </div>
            <a href="?page=kategori/daftarkategori" class="small-box-footer">
              Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $total_komentar ?></h3>
              <p>Total Komentar</p>
            </div>
            <div class="icon">
              <i class="fas fa-comments"></i>
            </div>
            <a href="?page=komentar/daftarkomentar" class="small-box-footer">
              Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Grafik & Tabel -->
      <div class="row">
        <!-- Grafik Konten per Kategori -->
        <div class="col-lg-6 col-12 mb-3">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h6 class="m-0">Grafik Konten per Kategori</h6>
            </div>
            <div class="card-body">
              <canvas id="grafikkategori" height="180"></canvas>
            </div>
          </div>
        </div>

        <!-- Tabel Ringkas -->
        <div class="col-lg-6 col-12">
          <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white">
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

          <div class="card shadow-sm">
            <div class="card-header bg-warning text-white">
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
                      <td><?= htmlspecialchars(substr($c['isikomentar'], 0, 50)) ?>...</td>
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

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikkategori').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [{
      label: 'Jumlah Konten',
      data: <?= json_encode($data) ?>,
      backgroundColor: 'rgba(54, 162, 235, 0.6)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>

<style>
@media (max-width: 576px) {
  .small-box .inner h3 { font-size: 1.6rem; }
  .small-box p { font-size: 0.9rem; }
  .card-header h6 { font-size: 0.9rem; }
  table th, table td { font-size: 0.8rem; }
}
</style>

<?php include '../../pages/user/footer.php'; ?>
