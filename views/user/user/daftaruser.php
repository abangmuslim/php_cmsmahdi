<?php
// ===============================================
// File: views/user/user/daftaruser.php
// Deskripsi: Daftar & Tambah User (2 kolom layout) CMS Mahdi
// ===============================================

require_once dirname(__DIR__, 3) . '/includes/ceksession.php';
require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<div class="content-wrapper p-3">
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- ================== KOLOM KIRI (FORM TAMBAH USER 1 KOLM) ================== -->
        <div class="col-md-4">
          <div class="card card-success">
            <div class="card-header bg-gradient-success">
              <h3 class="card-title"><i class="fas fa-plus-circle"></i> Form Tambah User</h3>
            </div>

            <form action="views/user/user/prosesuser.php" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input type="text" name="namauser" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <div class="input-group">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>

                <div class="form-group mt-3">
                  <label>Role</label>
                  <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="editor">Editor</option>
                  </select>
                </div>

                <div class="form-group mt-3">
                  <label>Foto (opsional)</label>
                  <input type="file" name="foto" id="fotoInput" class="form-control-file" accept=".jpg,.jpeg,.png,.gif,.webp">
                  <small class="form-text text-muted">Maksimal 2MB (jpg, png, gif, webp)</small>
                  <img id="previewFoto" src="uploads/user/default.png" alt="Preview Foto" class="img-thumbnail mt-2" width="250">
                </div>
              </div>

              <div class="card-footer text-right">
                <button type="reset" class="btn btn-warning btn-sm">
                  <i class="fas fa-retweet"></i> Reset
                </button>
                <button type="submit" name="aksi" value="tambah" class="btn btn-primary btn-sm">
                  <i class="fas fa-save"></i> Simpan
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
                        <a href="dashboard.php?hal=user/edituser&id=<?= $data['iduser']; ?>" class="btn btn-warning btn-sm me-1" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="views/user/user/prosesuser.php?aksi=hapus&id=<?= $data['iduser']; ?>"
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
        <!-- ================== END KOLOM ================== -->
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
