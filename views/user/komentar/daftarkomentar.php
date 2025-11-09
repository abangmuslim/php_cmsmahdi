<?php
include_once "../../includes/koneksi.php";
include_once "../../includes/ceksession.php";
include_once "../../pages/user/header.php";
include_once "../../pages/user/navbar.php";
include_once "../../pages/user/sidebar.php";
?>

<div class="container">
  <h2>Daftar Komentar</h2>
  <a href="tambahkomentar.php" class="btn btn-primary">+ Tambah Komentar</a>
  <br><br>

  <!-- Filter dan pencarian -->
  <form method="GET" action="">
    <label>Konten:</label>
    <select name="idkonten" onchange="this.form.submit()">
      <option value="">-- Semua Konten --</option>
      <?php
      $konten = mysqli_query($koneksi, "SELECT idkonten, judul FROM tb_konten ORDER BY judul ASC");
      while ($k = mysqli_fetch_array($konten)) {
        $selected = (isset($_GET['idkonten']) && $_GET['idkonten'] == $k['idkonten']) ? "selected" : "";
        echo "<option value='{$k['idkonten']}' $selected>{$k['judul']}</option>";
      }
      ?>
    </select>

    <input type="text" name="cari" placeholder="Cari isi komentar atau pengguna" value="<?php echo $_GET['cari'] ?? ''; ?>">
    <button type="submit">Cari</button>
  </form>
  <br>

  <?php
  // Pagination
  $limit = 10;
  $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
  $mulai = ($halaman - 1) * $limit;

  $where = "WHERE 1=1";
  if (!empty($_GET['idkonten'])) {
    $idkonten = mysqli_real_escape_string($koneksi, $_GET['idkonten']);
    $where .= " AND komentar.idkonten='$idkonten'";
  }
  if (!empty($_GET['cari'])) {
    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
    $where .= " AND (komentar.isikomentar LIKE '%$cari%' OR user.namapengguna LIKE '%$cari%')";
  }

  $totaldata = mysqli_num_rows(mysqli_query($koneksi, "
    SELECT * FROM tb_komentar komentar 
    LEFT JOIN tb_konten konten ON komentar.idkonten=konten.idkonten 
    LEFT JOIN tb_user user ON komentar.iduser=user.iduser 
    $where
  "));
  $totalhalaman = ceil($totaldata / $limit);

  $query = mysqli_query($koneksi, "
    SELECT komentar.*, konten.judul, user.namapengguna 
    FROM tb_komentar komentar
    LEFT JOIN tb_konten konten ON komentar.idkonten=konten.idkonten
    LEFT JOIN tb_user user ON komentar.iduser=user.iduser
    $where
    ORDER BY komentar.tanggal DESC
    LIMIT $mulai, $limit
  ");
  ?>

  <table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
      <th>No</th>
      <th>Konten</th>
      <th>Pengguna</th>
      <th>Isi Komentar</th>
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
        <td>{$data['namapengguna']}</td>
        <td>" . htmlspecialchars(substr($data['isikomentar'], 0, 50)) . "...</td>
        <td>{$data['tanggal']}</td>
        <td>{$data['status']}</td>
        <td>
          <a href='editkomentar.php?id={$data['idkomentar']}'>Edit</a> |
          <a href='proseskomentar.php?aksi=hapus&id={$data['idkomentar']}' onclick='return confirm(\"Hapus komentar ini?\")'>Hapus</a>
        </td>
      </tr>";
      $no++;
    }
    ?>
  </table>

  <div style="margin-top:20px; text-align:center;">
    <?php for ($i = 1; $i <= $totalhalaman; $i++): ?>
      <?php if ($i == $halaman): ?>
        <strong>[<?= $i ?>]</strong>
      <?php else: ?>
        <a href="?halaman=<?= $i ?>&idkonten=<?= $_GET['idkonten'] ?? '' ?>&cari=<?= $_GET['cari'] ?? '' ?>"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>
</div>

<?php include_once "../../pages/user/footer.php"; ?>
