<?php
include_once "../../includes/koneksi.php";
include_once "../../includes/ceksession.php";
include_once "../../pages/user/header.php";
include_once "../../pages/user/navbar.php";
include_once "../../pages/user/sidebar.php";
?>

<div class="container">
  <h2>Tambah Komentar</h2>
  <form action="proseskomentar.php" method="POST" onsubmit="return validasiForm()">
    <label>Konten:</label><br>
    <select name="idkonten" required>
      <option value="">-- Pilih Konten --</option>
      <?php
      $konten = mysqli_query($koneksi, "SELECT idkonten, judul FROM tb_konten ORDER BY judul ASC");
      while ($k = mysqli_fetch_array($konten)) {
        echo "<option value='{$k['idkonten']}'>{$k['judul']}</option>";
      }
      ?>
    </select><br><br>

    <label>Isi Komentar:</label><br>
    <textarea name="isikomentar" rows="4" required></textarea><br><br>

    <label>Status:</label><br>
    <select name="status">
      <option value="tampil">Tampil</option>
      <option value="sembunyi">Sembunyi</option>
    </select><br><br>

    <button type="submit" name="simpan">Simpan</button>
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
