<?php
// ===============================================
// File: views/user/konten/daftarkonten.php
// Deskripsi: Daftar Konten untuk Admin CMS Mahdi (final aman)
// ===============================================

// Load keamanan & koneksi
require_once dirname(__DIR__, 3) . '/includes/ceksession.php';
require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
?>

<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">

      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="m-0">Daftar Konten</h5>
          <div class="ml-auto">
            <a href="dashboard.php?hal=konten/tambahkonten" class="btn btn-info btn-sm text-white fw-bold" style="font-size: 1rem;">
              <i class="fa fa-plus"></i> Tambah Konten
            </a>
          </div>
        </div>

        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped align-middle mb-0">
  <thead class="text-center bg-light">
    <tr>
      <th style="width:5%">No</th>
      <th>Judul</th>
      <th>Isi Konten</th>
      <th>Kategori</th>
      <th>Tag</th>
      <th>Status</th>
      <th>Tanggal</th>
      <th>Gambar</th>
      <th style="width:15%">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $query = "SELECT k.*, c.namakategori, u.namauser
              FROM konten k
              LEFT JOIN kategori c ON k.idkategori = c.idkategori
              LEFT JOIN user u ON k.iduser = u.iduser
              ORDER BY k.idkonten DESC";
    $hasil = mysqli_query($koneksi, $query);

    while ($data = mysqli_fetch_assoc($hasil)):
        // Siapkan data aman
        $judul      = htmlspecialchars($data['judulkonten'] ?? '');
        $isi        = htmlspecialchars(strip_tags($data['isikonten'] ?? ''));
        if (strlen($isi) > 100) {
            $isi = substr($isi, 0, 100) . '...';
        }
        $kategori   = htmlspecialchars($data['namakategori'] ?? '-');
        $tag        = htmlspecialchars($data['tag'] ?? '-');
        $status     = htmlspecialchars($data['status'] ?? '-');
        $tanggal    = !empty($data['tanggalbuat']) ? date('d-m-Y H:i', strtotime($data['tanggalbuat'])) : '-';
        $namauser   = htmlspecialchars($data['namauser'] ?? '-');
        $gambar     = !empty($data['gambar']) ? $data['gambar'] : 'default.png';
    ?>
      <tr>
        <td class="text-center"><?= $no++; ?></td>
        <td><?= $judul; ?></td>
        <td><?= $isi; ?></td>
        <td><?= $kategori; ?></td>
        <td><?= $tag; ?></td>
        <td class="text-center">
          <span class="badge bg-<?= $status === 'publik' ? 'success' : 'secondary'; ?>">
            <?= ucfirst($status); ?>
          </span>
        </td>
        <td class="text-center"><?= $tanggal; ?></td>
        <td class="text-center">
          <img src="<?= url('uploads/konten/' . $gambar); ?>" width="50" class="img-thumbnail">
        </td>
        <td class="text-center">
          <a href="dashboard.php?hal=konten/editkonten&id=<?= $data['idkonten']; ?>" 
             class="btn btn-warning btn-sm me-1" title="Edit">
            <i class="fa fa-edit"></i>
          </a>
          <a href="views/user/konten/proseskonten.php?aksi=hapus&id=<?= $data['idkonten']; ?>" 
             onclick="return confirm('Yakin ingin menghapus konten ini?')" 
             class="btn btn-danger btn-sm" title="Hapus">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

        </div>
      </div>

    </div>
  </section>
</div>

<style>
  .content-wrapper { background-color: #f4f6f9; min-height: 100vh; }
  table img { border: 2px solid #ddd; }
  @media (max-width: 576px) { table th, table td { font-size: 0.8rem; } }
</style>
