<?php
include_once "../../includes/koneksi.php";
include_once "../../includes/fungsiupload.php";
include_once "../../includes/ceksession.php";

if (isset($_POST['simpan'])) {
  $judul = trim($_POST['judul']);
  $idkategori = $_POST['idkategori'];
  $isikonten = trim($_POST['isikonten']);
  $status = $_POST['status'];
  $iduser = $_SESSION['iduser'];
  $tanggal = date("Y-m-d H:i:s");

  if ($judul == "" || strlen($isikonten) < 10) {
    echo "<script>alert('Judul atau isi tidak valid!');history.back();</script>";
    exit;
  }

  $gambar = fungsiupload($_FILES['gambar'], "../../uploads/konten/");

  mysqli_query($koneksi, "INSERT INTO tb_konten (judul, idkategori, isikonten, gambar, status, iduser, tanggal)
    VALUES ('$judul','$idkategori','$isikonten','$gambar','$status','$iduser','$tanggal')");

  header("Location: daftarkonten.php");
  exit;
}

if (isset($_POST['update'])) {
  $id = $_POST['idkonten'];
  $judul = trim($_POST['judul']);
  $idkategori = $_POST['idkategori'];
  $isikonten = trim($_POST['isikonten']);
  $status = $_POST['status'];

  $gambar = fungsiupload($_FILES['gambar'], "../../uploads/konten/");
  if ($gambar) {
    mysqli_query($koneksi, "UPDATE tb_konten SET judul='$judul', idkategori='$idkategori', isikonten='$isikonten', gambar='$gambar', status='$status' WHERE idkonten='$id'");
  } else {
    mysqli_query($koneksi, "UPDATE tb_konten SET judul='$judul', idkategori='$idkategori', isikonten='$isikonten', status='$status' WHERE idkonten='$id'");
  }

  header("Location: daftarkonten.php");
  exit;
}

if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
  $id = $_GET['id'];
  $q = mysqli_fetch_array(mysqli_query($koneksi, "SELECT gambar FROM tb_konten WHERE idkonten='$id'"));
  if ($q['gambar'] && file_exists("../../uploads/konten/" . $q['gambar'])) {
    unlink("../../uploads/konten/" . $q['gambar']);
  }
  mysqli_query($koneksi, "DELETE FROM tb_konten WHERE idkonten='$id'");
  header("Location: daftarkonten.php");
  exit;
}
?>
