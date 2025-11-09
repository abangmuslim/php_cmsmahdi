<?php
include_once "../../includes/koneksi.php";
include_once "../../includes/ceksession.php";

if (isset($_POST['simpan'])) {
  $idkonten = $_POST['idkonten'];
  $isikomentar = trim($_POST['isikomentar']);
  $status = $_POST['status'];
  $iduser = $_SESSION['iduser'];
  $tanggal = date("Y-m-d H:i:s");

  if (strlen($isikomentar) < 5) {
    echo "<script>alert('Komentar terlalu pendek!');history.back();</script>";
    exit;
  }

  mysqli_query($koneksi, "INSERT INTO tb_komentar (idkonten, iduser, isikomentar, status, tanggal)
    VALUES ('$idkonten', '$iduser', '$isikomentar', '$status', '$tanggal')");
  header("Location: daftarkomentar.php");
  exit;
}

if (isset($_POST['update'])) {
  $idkomentar = $_POST['idkomentar'];
  $idkonten = $_POST['idkonten'];
  $isikomentar = trim($_POST['isikomentar']);
  $status = $_POST['status'];

  mysqli_query($koneksi, "UPDATE tb_komentar SET idkonten='$idkonten', isikomentar='$isikomentar', status='$status' WHERE idkomentar='$idkomentar'");
  header("Location: daftarkomentar.php");
  exit;
}

if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
  $id = $_GET['id'];
  mysqli_query($koneksi, "DELETE FROM tb_komentar WHERE idkomentar='$id'");
  header("Location: daftarkomentar.php");
  exit;
}
?>
