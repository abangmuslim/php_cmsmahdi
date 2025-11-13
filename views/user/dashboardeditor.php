<?php
// =======================================
// File: views/user/dashboardeditor.php
// Deskripsi: Dashboard utama untuk Editor CMS Mahdi
// =======================================

require_once __DIR__ . '/../../includes/koneksi.php';
require_once __DIR__ . '/../../includes/konfig.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Data ringkasan
$iduser = (int)($_SESSION['iduser'] ?? 0);
$namauser = htmlspecialchars($_SESSION['namauser'] ?? 'Editor');

// Hitung data utama
$total_kategori = $koneksi->query("SELECT COUNT(*) AS jml FROM kategori")->fetch_assoc()['jml'] ?? 0;
$total_konten   = $koneksi->query("SELECT COUNT(*) AS jml FROM konten WHERE iduser = $iduser")->fetch_assoc()['jml'] ?? 0;
$total_komentar = $koneksi->query("SELECT COUNT(*) AS jml FROM komentar")->fetch_assoc()['jml'] ?? 0;
$total_laporan  = $koneksi->query("SELECT COUNT(*) AS jml FROM konten WHERE status='publish'")->fetch_assoc()['jml'] ?? 0;
?>

<!-- ======================================= -->
<!-- Konten Dashboard Editor -->
<!-- ======================================= -->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <div>
        <h4 class="mb-0"><i class="fas fa-tachometer-alt mr-1 text-primary"></i> Dashboard Editor</h4>
        <p class="text-muted mb-0">Selamat datang kembali, <strong><?= $namauser; ?></strong> 👋</p>
      </div>
      <div>
        <small class="text-muted">Peran: <span class="badge badge-info">Editor</span></small>
      </div>
    </div>
  </section>

  <section class="content mt-3">
    <div class="container-fluid">
      <div class="row">
        <!-- Kategori -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $total_kategori; ?></h3>
              <p>Kategori</p>
            </div>
            <div class="icon"><i class="fas fa-folder"></i></div>
            <a href="dashboard.php?hal=kategori/daftarkategori" class="small-box-footer">
              Kelola Kategori <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Konten -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $total_konten; ?></h3>
              <p>Konten Anda</p>
            </div>
            <div class="icon"><i class="fas fa-newspaper"></i></div>
            <a href="dashboard.php?hal=konten/daftarkonten" class="small-box-footer">
              Lihat Semua <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Komentar -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $total_komentar; ?></h3>
              <p>Komentar</p>
            </div>
            <div class="icon"><i class="fas fa-comments"></i></div>
            <a href="dashboard.php?hal=komentar/daftarkomentar" class="small-box-footer">
              Tinjau Komentar <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Laporan -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $total_laporan; ?></h3>
              <p>Laporan Konten</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
            <a href="dashboard.php?hal=laporan/daftarlaporan" class="small-box-footer">
              Lihat Laporan <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Aktivitas -->
      <div class="card mt-3 shadow-sm">
        <div class="card-header bg-light d-flex align-items-center">
          <i class="fas fa-bullhorn text-primary mr-2"></i>
          <h5 class="mb-0">Aktivitas Terbaru</h5>
        </div>
        <div class="card-body">
          <p class="text-muted mb-0">Belum ada aktivitas terbaru. Silakan buat atau edit konten untuk memperbarui data di sini.</p>
        </div>
      </div>
    </div>
  </section>
</div>
