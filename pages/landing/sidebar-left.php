<div class="card">
  <div class="card-header bg-primary text-white">
    Kategori
  </div>
  <ul class="list-group list-group-flush">
    <?php
    $kategori = $koneksi->query("SELECT * FROM kategori ORDER BY namakategori ASC");
    while ($kat = $kategori->fetch_assoc()) {
      echo '<li class="list-group-item">
              <a href="index.php?halaman=daftarkonten&idkategori=' . $kat['idkategori'] . '">
                ' . htmlspecialchars($kat['namakategori']) . '
              </a>
            </li>';
    }
    ?>
  </ul>
</div>
