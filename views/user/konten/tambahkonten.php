<?php
include_once "../../includes/koneksi.php";
include_once "../../includes/ceksession.php";
include_once "../../pages/user/header.php";
include_once "../../pages/user/navbar.php";
include_once "../../pages/user/sidebar.php";
?>

<div class="container">
  <h2>Tambah Konten</h2>
  <form action="proseskonten.php" method="POST" enctype="multipart/form-data" onsubmit="return validasiForm()">
    <label>Judul:</label><br>
    <input type="text" name="judul" required><br><br>

    <label>Kategori:</label><br>
    <select name="idkategori" required>
      <option value="">-- Pilih Kategori --</option>
      <?php
      $kat = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY namakategori ASC");
      while ($k = mysqli_fetch_array($kat)) {
        echo "<option value='{$k['idkategori']}'>{$k['namakategori']}</option>";
      }
      ?>
    </select><br><br>

    <label>Isi Konten:</label><br>
    <textarea name="isikonten" rows="6" required></textarea><br><br>

    <label>Gambar:</label><br>
    <input type="file" name="gambar" accept="image/*"><br><br>

    <label>Status:</label><br>
    <select name="status">
      <option value="publik">Publik</option>
      <option value="draft">Draft</option>
    </select><br><br>

    <button type="submit" name="simpan">Simpan</button>
  </form>
</div>

<script>
function validasiForm() {
  const judul = document.querySelector('[name="judul"]').value.trim();
  const isi = document.querySelector('[name="isikonten"]').value.trim();
  const gambar = document.querySelector('[name="gambar"]').files[0];
  if (judul === "") { alert("Judul wajib diisi!"); return false; }
  if (isi.length < 10) { alert("Isi konten minimal 10 karakter!"); return false; }
  if (gambar) {
    const ekstensi = ['image/jpeg', 'image/png'];
    if (!ekstensi.includes(gambar.type)) { alert("Hanya JPG/PNG!"); return false; }
    if (gambar.size > 2 * 1024 * 1024) { alert("Maks 2MB!"); return false; }
  }
  return true;
}
</script>

<?php include_once "../../pages/user/footer.php"; ?>
