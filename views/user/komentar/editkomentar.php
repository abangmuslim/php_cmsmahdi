<?php
include_once "../../includes/koneksi.php";
include_once "../../includes/ceksession.php";
include_once "../../pages/user/header.php";
include_once "../../pages/user/navbar.php";
include_once "../../pages/user/sidebar.php";

$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tb_komentar WHERE idkomentar='$id'"));
?>

<div class="container">
  <h2>Edit Komentar</h2>
  <form action="proseskomentar.php" method="POST" onsubmit="return validasiForm()">
    <input type="hidden" name="idkomentar" value="<?= $data['idkomentar'] ?>">

    <label>Konten:</label><br>
    <select name="idkonten" required>
      <?php
      $konten = mysqli_query($koneksi, "SELECT idkonten, judul FROM tb_konten ORDER BY judul ASC");
      while ($k = mysqli_fetch_array($konten)) {
        $sel = ($k['idkonten'] == $data['idkonten']) ? "selected" : "";
        echo "<option value='{$k['idkonten']}' $sel>{$k['judul']}</option>";
      }
      ?>
    </select><br><br>

    <label>Isi Komentar:</label><br>
    <textarea name="isikomentar" rows="4" required><?= htmlspecialchars($data['isikomentar']) ?></textarea><br><br>

    <label>Status:</label><br>
    <select name="status">
      <option value="tampil" <?= $data['status']=='tampil'?'selected':'' ?>>Tampil</option>
      <option value="sembunyi" <?= $data['status']=='sembunyi'?'selected':'' ?>>Sembunyi</option>
    </select><br><br>

    <button type="submit" name="update">Update</button>
  </form>
</div>

<script>
function validasiForm() {
  const isi = document.querySelector('[name="isikomentar"]').value.trim();
  if (isi.length < 5) {
    alert("Isi komentar minimal 5 karakter!");
    return false;
  }
  return true;
}
</script>

<?php include_once "../../pages/user/footer.php"; ?>
