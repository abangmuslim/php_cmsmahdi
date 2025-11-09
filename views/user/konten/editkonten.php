<?php
include_once "../../includes/koneksi.php";
include_once "../../includes/ceksession.php";
include_once "../../pages/user/header.php";
include_once "../../pages/user/navbar.php";
include_once "../../pages/user/sidebar.php";

$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tb_konten WHERE idkonten='$id'"));
?>

<div class="container">
  <h2>Edit Konten</h2>
  <form action="proseskonten.php" method="POST" enctype="multipart/form-data" onsubmit="return validasiForm()">
    <input type="hidden" name="idkonten" value="<?= $data['idkonten'] ?>">

    <label>Judul:</label><br>
    <input type="text" name="judul" value="<?= $data['judul'] ?>" required><br><br>

    <label>Kategori:</label><br>
    <select name="idkategori" required>
      <?php
      $kat = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY namakategori ASC");
      while ($k = mysqli_fetch_array($kat)) {
        $sel = ($k['idkategori'] == $data['idkategori']) ? "selected" : "";
        echo "<option value='{$k['idkategori']}' $sel>{$k['namakategori']}</option>";
      }
      ?>
    </select><br><br>

    <label>Isi Konten:</label><br>
    <textarea name="isikonten" rows="6" required><?= $data['isikonten'] ?></textarea><br><br>

    <label>Gambar:</label><br>
    <?php if ($data['gambar']): ?>
      <img src='../../uploads/konten/<?= $data['gambar'] ?>' width='120'><br>
    <?php endif; ?>
    <input type="file" name="gambar" accept="image/*"><br><br>

    <label>Status:</label><br>
    <select name="status">
      <option value="publik" <?= $data['status']=='publik'?'selected':'' ?>>Publik</option>
      <option value="draft" <?= $data['status']=='draft'?'selected':'' ?>>Draft</option>
    </select><br><br>

    <button type="submit" name="update">Update</button>
  </form>
</div>

<script>
function validasiForm() {
  const judul = document.querySelector('[name="judul"]').value.trim();
  const isi = document.querySelector('[name="isikonten"]').value.trim();
  if (judul === "") { alert("Judul wajib diisi!"); return false; }
  if (isi.length < 10) { alert("Isi konten minimal 10 karakter!"); return false; }
  return true;
}
</script>

<?php include_once "../../pages/user/footer.php"; ?>
