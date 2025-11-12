<?php
// ======================================================
// File: views/user/laporan/daftarlaporan.php
// Deskripsi: Laporan data konten berdasarkan tanggal
// ======================================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1><i class="fas fa-chart-line"></i> Laporan Konten</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- Filter tanggal -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-filter"></i> Filter Tanggal</h3>
        </div>
        <div class="card-body">
          <form method="GET" action="dashboard.php" class="row g-3 align-items-end">
            <input type="hidden" name="hal" value="laporan/daftarlaporan">

            <div class="col-md-3">
              <label for="tgl_mulai" class="form-label">Dari Tanggal</label>
              <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control"
                     value="<?= $_GET['tgl_mulai'] ?? '' ?>" required>
            </div>

            <div class="col-md-3">
              <label for="tgl_selesai" class="form-label">Sampai Tanggal</label>
              <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control"
                     value="<?= $_GET['tgl_selesai'] ?? '' ?>" required>
            </div>

            <div class="col-md-3">
              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search"></i> Tampilkan
              </button>
            </div>

<div class="col-md-3">
  <a href="views/user/laporan/cetaklaporan.php?tgl_mulai=<?= $_GET['tgl_mulai'] ?? '' ?>&tgl_selesai=<?= $_GET['tgl_selesai'] ?? '' ?>"
     target="_blank" class="btn btn-danger w-100">
    <i class="fas fa-print"></i> Cetak Laporan
  </a>
</div>

          </form>
        </div>
      </div>

      <!-- Tabel Laporan -->
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
          <h3 class="card-title"><i class="fas fa-table"></i> Data Laporan Konten</h3>
        </div>
        <div class="card-body">
          <table id="tabelLaporan" class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Judul Konten</th>
                <th>Kategori</th>
                <th>Tag</th>
                <th>User Pembuat</th>
                <th>Tanggal Posting</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $tgl_mulai = $_GET['tgl_mulai'] ?? '';
              $tgl_selesai = $_GET['tgl_selesai'] ?? '';

              $sql = "SELECT k.judulkonten, k.tag, c.namakategori, u.namauser, k.tanggalbuat, k.status
                      FROM konten k
                      LEFT JOIN kategori c ON k.idkategori = c.idkategori
                      LEFT JOIN user u ON k.iduser = u.iduser";

              if ($tgl_mulai && $tgl_selesai) {
                  $sql .= " WHERE DATE(k.tanggalbuat) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
              }

              $sql .= " ORDER BY k.tanggalbuat DESC";
              $result = mysqli_query($koneksi, $sql);

              if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['judulkonten']}</td>
                            <td>{$row['namakategori']}</td>
                            <td>{$row['tag']}</td>
                            <td>{$row['namauser']}</td>
                            <td>{$row['tanggalbuat']}</td>
                            <td><span class='badge bg-" . ($row['status'] == 'publish' ? 'success' : 'secondary') . "'>"
                                  . ucfirst($row['status']) . "</span></td>
                          </tr>";
                      $no++;
                  }
              } else {
                  echo "<tr><td colspan='7' class='text-center text-muted'>Tidak ada data untuk rentang tanggal ini.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Script DataTables -->
<link rel="stylesheet" href="asset/pluggin/datatables/datatables.min.css">
<script src="asset/pluggin/datatables/datatables.min.js"></script>
<script src="asset/pluggin/datatables/buttons.min.js"></script>
<script src="asset/pluggin/datatables/jszip.min.js"></script>
<script src="asset/pluggin/datatables/pdfmake.min.js"></script>
<script src="asset/pluggin/datatables/vfs_fonts.js"></script>
<script src="asset/pluggin/datatables/buttons.html5.min.js"></script>
<script src="asset/pluggin/datatables/buttons.print.min.js"></script>

<script>
  $(document).ready(function() {
    $('#tabelLaporan').DataTable({
      dom: 'Bfrtip',
      buttons: [
        { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', className: 'btn btn-success' },
        { extend: 'pdfHtml5', text: '<i class="fas fa-file-pdf"></i> PDF', className: 'btn btn-danger' },
        { extend: 'print', text: '<i class="fas fa-print"></i> Print', className: 'btn btn-secondary' }
      ],
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
      }
    });
  });
</script>
