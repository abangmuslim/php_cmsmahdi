<?php
// ====================================================
// File: views/auth/login.php
// Deskripsi: Halaman login untuk CMSMAHDI (zona publik)
// ====================================================

require_once __DIR__ . '/../../includes/path.php';
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Redirect jika sudah login
if (isset($_SESSION['role'])) {
  if ($_SESSION['role'] === 'admin') {
    header("Location: " . BASE_URL . "dashboard.php");
    exit();
  } elseif ($_SESSION['role'] === 'editor') {
    header("Location: " . BASE_URL . "pages/editor/dashboardeditor.php");
    exit();
  }
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  if ($username === '' || $password === '') {
    $error = "Username dan password wajib diisi.";
  } else {
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      if (md5($password) === $user['password']) {
        $_SESSION['iduser']    = $user['iduser'];
        $_SESSION['namauser']  = $user['namauser'];
        $_SESSION['role']      = $user['role'];
        $_SESSION['username']  = $user['username'];

        if ($user['role'] === 'admin') {
          header("Location: " . BASE_URL . "dashboard.php");
        } else {
          header("Location: " . BASE_URL . "pages/editor/dashboardeditor.php");
        }
        exit();
      } else {
        $error = "Password salah.";
      }
    } else {
      $error = "Username tidak ditemukan.";
    }
  }
}
?>

<!-- ==================================================== -->
<!-- TAMPILAN LOGIN DENGAN FOOTER SELALU TERLIHAT -->
<!-- ==================================================== -->

<style>
  .login-wrapper {
    min-height: calc(100vh - 180px);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .toggle-password {
    position: absolute;
    right: 15px;
    top: 38px;
    cursor: pointer;
    color: #888;
  }
</style>

<div class="login-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0">
          <div class="card-body p-4">
            <h3 class="text-center mb-4">Login CMS Mahdi</h3>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>index.php?hal=login">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>

              <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="toggle-password" onclick="togglePassword()">
                  👁️
                </span>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>

            <div class="text-center mt-3">
              <a href="<?= BASE_URL ?>">← Kembali ke Beranda</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
  }
</script>