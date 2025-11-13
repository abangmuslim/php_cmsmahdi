<?php
// =============================================
// File: views/user/user/edituser.php
// Deskripsi: Edit User 2 kolom proporsional (form + daftar user)
// =============================================

require_once dirname(__DIR__, 3) . '/includes/ceksession.php';
require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Pastikan hanya admin yang bisa akses
if ($role !== 'admin') {
  header("Location: ../../../index.php");
  exit;
}

// Ambil data user berdasarkan id
$iduser = $_GET['id'] ?? 0;
$query  = mysqli_query($koneksi, "SELECT * FROM user WHERE iduser = '$iduser'");
$data   = mysqli_fetch_assoc($query);

if (!$data) {
  echo "<div class='alert alert-danger'>Data user tidak ditemukan!</div>";
  exit;
}

// Tentukan path foto
$fotoPath = "uploads/user/" . htmlspecialchars($data['foto']);
if (!file_exists(dirname(__DIR__, 3) . "/$fotoPath") || empty($data['foto'])) {
  $fotoPath = "uploads/user/default.png";
}
?>

<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- ================== KOLOM KIRI (FORM EDIT USER) ================== -->
        <div class="col-md-4">
          <div class="card card-primary">
            <div class="card-header bg-gradient-primary">
              <h3 class="card-title"><i class="fas fa-edit"></i> Form Edit User</h3>
            </div>

            <form method="POST" action="views/user/user/prosesuser.php" enctype="multipart/form-data">
              <input type="hidden" name="aksi" value="update">
              <input type="hidden" name="iduser" value="<?= htmlspecialchars($data['iduser']) ?>">
              <input type="hidden" name="fotolama" value="<?= htmlspecialchars($data['foto']) ?>">

              <div class="card-body">
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input type="text" name="namauser" class="form-control" value="<?= htmlspecialchars($data['namauser']) ?>" required>
                </div>

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
                </div>

                <div class="form-group">
                  <label>Password (Kosongkan jika tidak diubah)</label>
                  <div class="input-group">
                    <input id="password" type="password" name="password" class="form-control" placeholder="••••••••">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
                </div>

                <div class="form-group mt-3">
                  <label>Role</label>
                  <select name="role" class="form-control" required>
                    <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="editor" <?= $data['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                  </select>
                </div>

                <div class="form-group mt-3 text-center">
                  <label>Foto Saat Ini</label><br>
                  <img id="previewFoto" src="<?= $fotoPath ?>" alt="Foto User" class="img-thumbnail mb-2" width="250">
                  <input type="file" name="foto" id="fotoInput" class="form-control mt-2" accept="image/*">
                </div>
              </div>

              <div class="card-footer text-right">
                <a href="dashboard.php?hal=user/daftaruser" class="btn btn-secondary btn-sm">
                  <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="reset" class="btn btn-warning btn-sm">
                  <i class="fas fa-retweet"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fas fa-save"></i> Simpan Perubahan
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- ================== KOLOM KANAN (DAFTAR USER) ================== -->
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h5 class="m-0">Daftar User</h5>
              <div class="ml-auto">
                <a href="dashboard.php?hal=user/daftaruser" class="btn btn-light btn-sm text-primary fw-bold" style="font-size: 1rem;">
                  <i class="fa fa-sync"></i> Refresh
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

                  while ($dataList = mysqli_fetch_assoc($hasil)):
                    $foto = !empty($dataList['foto']) ? $dataList['foto'] : 'default.png';
                  ?>
                    <tr>
                      <td class="text-center"><?= $no++; ?></td>
                      <td><?= htmlspecialchars($dataList['namauser']); ?></td>
                      <td><?= htmlspecialchars($dataList['username']); ?></td>
                      <td class="text-center">
                        <span class="badge bg-<?= $dataList['role'] == 'admin' ? 'danger' : 'success'; ?>">
                          <?= ucfirst($dataList['role']); ?>
                        </span>
                      </td>
                      <td class="text-center">
                        <img src="<?= url('uploads/user/' . $foto); ?>" width="40" class="rounded-circle shadow-sm border">
                      </td>
                      <td class="text-center">
                        <a href="dashboard.php?hal=user/edituser&id=<?= $dataList['iduser']; ?>" class="btn btn-warning btn-sm me-1" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="views/user/user/prosesuser.php?aksi=hapus&id=<?= $dataList['iduser']; ?>"
                           onclick="return confirm('Yakin ingin menghapus user ini?')"
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

      </div>
    </div>
  </section>
</div>

<style>
  .content-wrapper {
    background-color: #f4f6f9;
    min-height: 100vh;
  }

  .card {
    border-radius: 0.5rem;
  }

  .card-title {
    font-weight: bold;
  }

  table img {
    border: 2px solid #ddd;
  }

  @media (max-width: 768px) {
    .col-md-4, .col-md-8 {
      flex: 100%;
      max-width: 100%;
      margin-bottom: 1rem;
    }

    table th, table td {
      font-size: 0.85rem;
    }
  }
</style>

<!-- Preview foto otomatis -->
<script>
document.getElementById('fotoInput').addEventListener('change', function(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('previewFoto').src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});
</script>

<!-- Toggle Password -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('togglePassword');
  const input = document.getElementById('password');
  const icon = document.getElementById('toggleIcon');

  btn.addEventListener('click', function () {
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  });
});
</script>
