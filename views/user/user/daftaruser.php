<?php
// ===============================================
// File: views/user/user/daftaruser.php
// Deskripsi: Daftar User untuk Admin CMSMAHDI
// ===============================================

// Load keamanan & koneksi
require_once dirname(__DIR__, 3) . '/includes/ceksession.php';
require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
?>

<!-- =============================================== -->
<!--  BAGIAN KONTEN (mengikuti struktur AdminLTE)    -->
<!-- =============================================== -->
<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">

      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="m-0">Daftar User</h5>
          <div class="ml-auto">
            <a href="dashboard.php?hal=user/tambahuser" class="btn btn-info btn-sm text-white fw-bold" style="font-size: 1rem;">
              <i class="fa fa-plus"></i> Tambah User
            </a>
          </div>
        </div>


        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="text-center bg-light">
              <tr>
                <th style="width:5%">No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Foto</th>
                <th style="width:15%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $query = "SELECT * FROM user ORDER BY iduser DESC";
              $hasil = mysqli_query($koneksi, $query);

              while ($data = mysqli_fetch_assoc($hasil)):
                $foto = !empty($data['foto']) ? $data['foto'] : 'default.png';
              ?>
                <tr>
                  <td class="text-center"><?= $no++; ?></td>
                  <td><?= htmlspecialchars($data['namauser']); ?></td>
                  <td><?= htmlspecialchars($data['username']); ?></td>
                  <td class="text-center">
                    <span class="badge bg-<?= $data['role'] == 'admin' ? 'danger' : 'success'; ?>">
                      <?= ucfirst($data['role']); ?>
                    </span>
                  </td>
                  <td class="text-center">
                    <img src="<?= url('uploads/user/' . $foto); ?>" width="40" class="rounded-circle shadow-sm border">
                  </td>
                  <td class="text-center">
                    <!-- Tombol Edit -->
                    <a href="dashboard.php?hal=user/edituser&id=<?= $data['iduser']; ?>"
                      class="btn btn-warning btn-sm me-1"
                      title="Edit">
                      <i class="fa fa-edit"></i>
                    </a>

                    <!-- Tombol Hapus -->
                    <a href="views/user/user/prosesuser.php?aksi=hapus&id=<?= $data['iduser']; ?>"
                      onclick="return confirm('Yakin ingin menghapus user ini?')"
                      class="btn btn-danger btn-sm"
                      title="Hapus">
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

<!-- =============================================== -->
<!--  STYLE TAMBAHAN KHUSUS UNTUK HALAMAN INI        -->
<!-- =============================================== -->
<style>
  .content-wrapper {
    background-color: #f4f6f9;
    min-height: 100vh;
  }

  table img {
    border: 2px solid #ddd;
  }

  @media (max-width: 576px) {

    table th,
    table td {
      font-size: 0.8rem;
    }
  }
</style>