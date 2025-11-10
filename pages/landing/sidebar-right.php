<div class="card mb-4">
  <div class="card-header bg-success text-white">Berita Populer</div>
  <ul class="list-group list-group-flush">
    <?php
    $populer = $koneksi->query("SELECT idkonten, judulkonten FROM konten WHERE status='publik' ORDER BY tanggalbuat DESC LIMIT 5");
    while ($pop = $populer->fetch_assoc()) {
      echo '<li class="list-group-item">
              <a href="' . BASE_URL . 'detilkonten?id=' . $pop['idkonten'] . '" class="text-decoration-none">'
                . htmlspecialchars($pop['judulkonten']) .
              '</a>
            </li>';
    }
    ?>
  </ul>
</div>

<div class="card">
  <div class="card-header bg-info text-white">Tag Populer</div>
  <div class="card-body">
    <?php
    // Daftar tag populer (statis, tapi link dinamis berdasarkan idkategori)
    $tags = ['Teknologi', 'Pendidikan', 'Kesehatan', 'Ekonomi'];

    foreach ($tags as $tag) {
      $stmt = $koneksi->prepare("SELECT idkategori FROM kategori WHERE namakategori = ?");
      $stmt->bind_param("s", $tag);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();

      if ($row) {
        echo '<a href="' . BASE_URL . 'kategori?id=' . $row['idkategori'] . '" 
                class="badge bg-secondary text-decoration-none me-1 mb-1">'
              . htmlspecialchars($tag) .
             '</a>';
      }
    }
    ?>
  </div>
</div>