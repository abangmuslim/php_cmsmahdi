<?php
// =======================================
// File: views/user/dashboardadmin.php
// Deskripsi: Tampilan dashboard utama untuk admin CMSMAHDI
// =======================================

// Asumsi koneksi dan session sudah dimuat dari dashboard.php

// Statistik ringkas
$total_user     = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM user"))['jumlah'];
$total_konten   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM konten"))['jumlah'];
$total_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM kategori"))['jumlah'];
$total_komentar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM komentar WHERE status='tampil'"))['jumlah'];

// Grafik konten per kategori
$hasil_kategori = mysqli_query($koneksi, "
  SELECT kategori.namakategori, COUNT(konten.idkonten) AS jumlah
  FROM kategori
  LEFT JOIN konten ON konten.idkategori = kategori.idkategori
  GROUP BY kategori.idkategori
");
$label_kategori = []; $jumlah_konten = [];
while ($data = mysqli_fetch_assoc($hasil_kategori)) {
  $label_kategori[] = $data['namakategori'];
  $jumlah_konten[] = $data['jumlah'];
}

// Konten dan komentar terbaru
$konten_terbaru = mysqli_query($koneksi, "
  SELECT judulkonten, tanggalbuat 
  FROM konten 
  WHERE status='publik' 
  ORDER BY tanggalbuat DESC 
  LIMIT 5
");

$komentar_terbaru = mysqli_query($koneksi, "
  SELECT namakomentar, isikomentar, tanggalbuat 
  FROM komentar 
  WHERE status='tampil' 
  ORDER BY tanggalbuat DESC 
  LIMIT 5
");
?>

<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">

      <!-- Statistik Ringkas -->
      <div class="row">
        <?php
        $statistik = [
          ['warna' => 'info', 'jumlah' => $total_user, 'label' => 'Total User', 'ikon' => 'users', 'link' => 'user/daftaruser'],
          ['warna' => 'success', 'jumlah' => $total_konten, 'label' => 'Total Konten', 'ikon' => 'newspaper', 'link' => 'konten/daftarkonten'],
          ['warna' => 'warning', 'jumlah' => $total_kategori, 'label' => 'Total Kategori', 'ikon' => 'list', 'link' => 'kategori/daftarkategori'],
          ['warna' => 'danger', 'jumlah' => $total_komentar, 'label' => 'Total Komentar', 'ikon' => 'comments', 'link' => 'komentar/daftarkomentar'],
        ];
        foreach ($statistik as $item) {
        ?>
        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
          <div class="small-box bg-<?= $item['warna'] ?>">
            <div class="inner">
              <h3><?= $item['jumlah'] ?></h3>
              <p><?= $item['label'] ?></p>
            </div>
            <div class="icon"><i class="fas fa-<?= $item['ikon'] ?>"></i></div>
            <a href="dashboard.php?hal=<?= $item['link'] ?>" class="small-box-footer">
              Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <?php } ?>
      </div>

      <!-- Grafik dan Tabel Ringkas -->
      <div class="row">
        <!-- Grafik Konten per Kategori -->
        <div class="col-lg-6 col-12 mb-3">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white"><h6 class="m-0">Grafik Konten per Kategori</h6></div>
            <div class="card-body"><canvas id="grafikkategori" height="180"></canvas></div>
          </div>
        </div>

        <!-- Tabel Konten dan Komentar Terbaru -->
        <div class="col-lg-6 col-12">
          <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white"><h6 class="m-0">Konten Terbaru</h6></div>
            <div class="card-body p-2">
              <table class="table table-sm table-striped mb-0">
                <thead><tr><th>Judul</th><th>Tanggal</th></tr></thead>
                <tbody>
                  <?php while ($konten = mysqli_fetch_assoc($konten_terbaru)) { ?>
                  <tr>
                    <td><?= htmlspecialchars($konten['judulkonten']) ?></td>
                    <td><?= date('d/m/Y', strtotime($konten['tanggalbuat'])) ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card shadow-sm">
            <div class="card-header bg-warning text-white"><h6 class="m-0">Komentar Terbaru</h6></div>
            <div class="card-body p-2">
              <table class="table table-sm table-striped mb-0">
                <thead><tr><th>Nama</th><th>Komentar</th><th>Tanggal</th></tr></thead>
                <tbody>
                  <?php while ($komentar = mysqli_fetch_assoc($komentar_terbaru)) { ?>
                  <tr>
                    <td><?= htmlspecialchars($komentar['namakomentar']) ?></td>
                    <td><?= htmlspecialchars(substr($komentar['isikomentar'], 0, 50)) ?>...</td>
                    <td><?= date('d/m/Y', strtotime($komentar['tanggalbuat'])) ?></td>
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
    labels: <?= json_encode($label_kategori) ?>,
    datasets: [{
      label: 'Jumlah Konten',
      data: <?= json_encode($jumlah_konten) ?>,
      backgroundColor: 'rgba(54, 162, 235, 0.6)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: { y: { beginAtZero: true } }
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