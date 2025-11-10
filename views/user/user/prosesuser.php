<?php
// ===============================================================
// File: views/user/user/prosesuser.php
// Deskripsi: Logic backend CRUD untuk manajemen user CMS Mahdi
// ===============================================================

require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
require_once dirname(__DIR__, 3) . '/includes/fungsivalidasi.php';
require_once dirname(__DIR__, 3) . '/includes/fungsiupload.php';
require_once dirname(__DIR__, 3) . '/includes/ceksession.php';

// Ambil aksi (prioritaskan POST)
$aksi = $_POST['aksi'] ?? ($_GET['aksi'] ?? '');

// Lokasi folder upload
$folderUpload = dirname(__DIR__, 3) . '/uploads/user/';

// =====================================================
// TAMBAH USER
// =====================================================
if ($aksi === 'tambah') {
    $nama     = bersihkan($_POST['namauser'] ?? '');
    $username = bersihkan($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email    = bersihkan($_POST['email'] ?? '');
    $role     = bersihkan($_POST['role'] ?? 'editor');

    // Validasi wajib isi
    if (empty($nama) || empty($username) || empty($password) || empty($email)) {
        header("Location: ../../../dashboard.php?hal=user/tambahuser&status=error_kosong");
        exit;
    }

    // Validasi role
    $roleValid = ['admin', 'editor'];
    if (!in_array($role, $roleValid)) {
        $role = 'editor';
    }

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Upload foto baru
    $foto = upload_gambar($_FILES['foto'], $folderUpload);

    // Simpan ke database
    $stmt = $koneksi->prepare("INSERT INTO user (namauser, username, password, email, role, foto) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nama, $username, $passwordHash, $email, $role, $foto);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=user/daftaruser&status=sukses_tambah");
    exit;
}

// =====================================================
// UPDATE USER
// =====================================================
elseif ($aksi === 'update') {
    $id       = intval($_POST['iduser'] ?? 0);
    $nama     = bersihkan($_POST['namauser'] ?? '');
    $username = bersihkan($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email    = bersihkan($_POST['email'] ?? '');
    $role     = bersihkan($_POST['role'] ?? 'editor');
    $fotoLama = $_POST['fotolama'] ?? 'default.png';

    // Validasi role
    $roleValid = ['admin', 'editor'];
    if (!in_array($role, $roleValid)) {
        $role = 'editor';
    }

    // Ambil data lama (untuk hapus foto jika diganti)
    $stmtOld = $koneksi->prepare("SELECT foto FROM user WHERE iduser = ?");
    $stmtOld->bind_param("i", $id);
    $stmtOld->execute();
    $old = $stmtOld->get_result()->fetch_assoc();
    $stmtOld->close();

    // Siapkan query update dinamis
    $query = "UPDATE user SET namauser=?, username=?, email=?, role=?";
    $params = [$nama, $username, $email, $role];
    $types  = "ssss";

    // Jika password diisi, update juga
    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query .= ", password=?";
        $params[] = $passwordHash;
        $types .= "s";
    }

    // Jika ada foto baru, upload dan ganti
    if (!empty($_FILES['foto']['name'])) {
        $fotoBaru = upload_gambar($_FILES['foto'], $folderUpload);

        // Hapus foto lama jika bukan default
        if (!empty($old['foto']) && $old['foto'] !== 'default.png') {
            $pathLama = $folderUpload . $old['foto'];
            if (file_exists($pathLama)) unlink($pathLama);
        }

        $query .= ", foto=?";
        $params[] = $fotoBaru;
        $types .= "s";
    }

    // WHERE iduser
    $query .= " WHERE iduser=?";
    $params[] = $id;
    $types .= "i";

    // Jalankan update
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=user/daftaruser&status=sukses_edit");
    exit;
}

// =====================================================
// HAPUS USER
// =====================================================
elseif ($aksi === 'hapus') {
    $id = intval($_GET['id'] ?? 0);

    // Ambil data lama
    $stmtFoto = $koneksi->prepare("SELECT foto FROM user WHERE iduser=?");
    $stmtFoto->bind_param("i", $id);
    $stmtFoto->execute();
    $fotoData = $stmtFoto->get_result()->fetch_assoc();
    $stmtFoto->close();

    // Hapus file fisik jika bukan default.png
    if ($fotoData && $fotoData['foto'] !== 'default.png') {
        $path = $folderUpload . $fotoData['foto'];
        if (file_exists($path)) unlink($path);
    }

    // Hapus dari database
    $stmt = $koneksi->prepare("DELETE FROM user WHERE iduser=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=user/daftaruser&status=sukses_hapus");
    exit;
}

// =====================================================
// DEFAULT: AKSI TIDAK VALID
// =====================================================
else {
    header("Location: ../../../dashboard.php?hal=user/daftaruser&status=invalid_aksi");
    exit;
}
?>
