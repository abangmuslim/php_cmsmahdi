<?php
include_once "../../includes/koneksi.php";
include_once "../../includes/ceksession.php";
include_once "../../pages/user/header.php";
include_once "../../pages/user/navbar.php";
include_once "../../pages/user/sidebar.php";
?>

<div class="container">
  <h2>Daftar Konten</h2>
  <a href="tambahkonten.php" class="btn btn-primary">+ Tambah Konten</a>
  <br><br>

  <!-- Filter Kategori dan Pencarian -->
  <form method="GET" action="">
    <label>Kategori:</label>
    <select name="idkategori" onchange="this.form.submit()">
      <option value="">-- Semua Kategori --</option>
      <?php
      $kat = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY namakategori ASC");
      while ($k = mysqli_fetch_array($kat)) {
        $selected = (isset($_GET['idkategori']) && $_GET['idkategori'] == $k['idkategori']) ? "selected" : "";
        echo "<option value='{$k['idkategori']}' $selected>{$k['namakategori']}</option>";
      }
      ?>
    </select>

    <input type="text" name="cari" placeholder="Cari judul atau penulis" value="<?php echo $_GET['cari'] ?? ''; ?>">
    <button type="submit">Cari</button>
  </form>
  <br>

  <?php
  // Pagination
  $limit = 10;
  $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
  $mulai = ($halaman - 1) * $limit;

  // Filter dan pencarian
  $where = "WHERE 1=1";
  if (!empty($_GET['idkategori'])) {
    $idkategori = mysqli_real_escape_string($koneksi, $_GET['idkategori']);
    $where .= " AND konten.idkategori='$idkategori'";
  }
  if (!empty($_GET['cari'])) {
    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
    $where .= " AND (konten.judul LIKE '%$cari%' OR user.namapengguna LIKE '%$cari%')";
  }

  // Total data dan query utama
  $totaldata = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tb_konten konten LEFT JOIN tb_user user ON konten.iduser=user.iduser $where"));
  $totalhalaman = ceil($totaldata / $limit);

  $query = mysqli_query($koneksi, "
    SELECT konten.*, kategori.namakategori, user.namapengguna 
    FROM tb_konten konten
    LEFT JOIN tb_kategori kategori ON konten.idkategori = kategori.idkategori
    LEFT JOIN tb_user user ON konten.iduser = user.iduser
    $where
    ORDER BY konten.tanggal DESC
    LIMIT $mulai, $limit
  ");
  ?>

  <table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Kategori</th>
      <th>Penulis</th>
      <th>Tanggal</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    <?php
    $no = $mulai + 1;
    while ($data = mysqli_fetch_array($query)) {
      echo "
      <tr>
        <td>$no</td>
        <td>{$data['judul']}</td>
        <td>{$data['namakategori']}</td>
        <td>{$data['namapengguna']}</td>
        <td>{$data['tanggal']}</td>
        <td>{$data['status']}</td>
        <td>
          <a href='editkonten.php?id={$data['idkonten']}'>Edit</a> | 
          <a href='proseskonten.php?aksi=hapus&id={$data['idkonten']}' onclick='return confirm(\"Yakin ingin hapus konten ini?\")'>Hapus</a>
        </td>
      </tr>";
      $no++;
    }
    ?>
  </table>

  <!-- Pagination -->
  <div style="margin-top:20px; text-align:center;">
    <?php for ($i = 1; $i <= $totalhalaman; $i++): ?>
      <?php if ($i == $halaman): ?>
        <strong>[<?= $i ?>]</strong>
      <?php else: ?>
        <a href="?halaman=<?= $i ?>&idkategori=<?= $_GET['idkategori'] ?? '' ?>&cari=<?= $_GET['cari'] ?? '' ?>"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>
</div>

<?php include_once "../../pages/user/footer.php"; ?>
