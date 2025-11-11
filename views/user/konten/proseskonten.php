<?php
// ===============================================================
// File: views/user/konten/proseskonten.php
// Deskripsi: Logic backend CRUD untuk manajemen konten CMS Mahdi
// ===============================================================

require_once dirname(__DIR__, 3) . '/includes/koneksi.php';
require_once dirname(__DIR__, 3) . '/includes/fungsivalidasi.php';
require_once dirname(__DIR__, 3) . '/includes/fungsiupload.php';
require_once dirname(__DIR__, 3) . '/includes/ceksession.php';

// Ambil aksi (prioritaskan POST)
$aksi = $_POST['aksi'] ?? ($_GET['aksi'] ?? '');

// Lokasi folder upload gambar konten
$folderUpload = dirname(__DIR__, 3) . '/uploads/konten/';

// Ambil id user dari session
$iduser = $_SESSION['iduser'] ?? 0;

// =====================================================
// TAMBAH KONTEN
// =====================================================
if ($aksi === 'tambah') {
    $judul      = bersihkan($_POST['judul'] ?? '');
    $isi        = $_POST['isi'] ?? '';
    $idkategori = intval($_POST['idkategori'] ?? 0);
    $tag        = bersihkan($_POST['tag'] ?? '');
    $status     = bersihkan($_POST['status'] ?? 'draft');
    $tanggal    = date('Y-m-d H:i:s');

    // Validasi wajib isi
    if (empty($judul) || empty($isi) || $idkategori <= 0) {
        header("Location: ../../../dashboard.php?hal=konten/tambahkonten&status=error_kosong");
        exit;
    }

    // Upload gambar (opsional)
    $gambar = upload_gambar($_FILES['gambar'] ?? null, $folderUpload);

    // Insert ke database
    $stmt = $koneksi->prepare("INSERT INTO konten (idkategori, iduser, judulkonten, isikonten, gambar, tag, status, tanggalbuat) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $idkategori, $iduser, $judul, $isi, $gambar, $tag, $status, $tanggal);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=konten/daftarkonten&status=sukses_tambah");
    exit;
}

// =====================================================
// UPDATE KONTEN
// =====================================================
elseif ($aksi === 'update') {
    $idkonten   = intval($_POST['idkonten'] ?? 0);
    $judul      = bersihkan($_POST['judul'] ?? '');
    $isi        = $_POST['isi'] ?? '';
    $idkategori = intval($_POST['idkategori'] ?? 0);
    $tag        = bersihkan($_POST['tag'] ?? '');
    $status     = bersihkan($_POST['status'] ?? 'draft');

    // Validasi wajib isi
    if (empty($judul) || empty($isi) || $idkategori <= 0) {
        header("Location: ../../../dashboard.php?hal=konten/editkonten&id=$idkonten&status=error_kosong");
        exit;
    }

    // Ambil data lama
    $stmtOld = $koneksi->prepare("SELECT gambar FROM konten WHERE idkonten=?");
    $stmtOld->bind_param("i", $idkonten);
    $stmtOld->execute();
    $old = $stmtOld->get_result()->fetch_assoc();
    $stmtOld->close();

    if (!$old) {
        header("Location: ../../../dashboard.php?hal=konten/daftarkonten&status=error_notfound");
        exit;
    }

    // Query update
    $query  = "UPDATE konten SET idkategori=?, judulkonten=?, isikonten=?, tag=?, status=?";
    $params = [$idkategori, $judul, $isi, $tag, $status];
    $types  = "issss";

    // Upload gambar baru jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $gambarBaru = upload_gambar($_FILES['gambar'], $folderUpload);

        if (!empty($old['gambar']) && file_exists($folderUpload . $old['gambar'])) {
            unlink($folderUpload . $old['gambar']);
        }

        $query .= ", gambar=?";
        $params[] = $gambarBaru;
        $types .= "s";
    }

    $query .= " WHERE idkonten=?";
    $params[] = $idkonten;
    $types .= "i";

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=konten/daftarkonten&status=sukses_edit");
    exit;
}

// =====================================================
// HAPUS KONTEN
// =====================================================
elseif ($aksi === 'hapus') {
    $idkonten = intval($_GET['id'] ?? 0);

    // Ambil data lama
    $stmtOld = $koneksi->prepare("SELECT gambar FROM konten WHERE idkonten=?");
    $stmtOld->bind_param("i", $idkonten);
    $stmtOld->execute();
    $old = $stmtOld->get_result()->fetch_assoc();
    $stmtOld->close();

    // Hapus file gambar jika ada
    if ($old && !empty($old['gambar']) && file_exists($folderUpload . $old['gambar'])) {
        unlink($folderUpload . $old['gambar']);
    }

    // Hapus record
    $stmt = $koneksi->prepare("DELETE FROM konten WHERE idkonten=?");
    $stmt->bind_param("i", $idkonten);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../dashboard.php?hal=konten/daftarkonten&status=sukses_hapus");
    exit;
}

// =====================================================
// DEFAULT: AKSI TIDAK VALID
// =====================================================
else {
    header("Location: ../../../dashboard.php?hal=konten/daftarkonten&status=invalid_aksi");
    exit;
}
?>
