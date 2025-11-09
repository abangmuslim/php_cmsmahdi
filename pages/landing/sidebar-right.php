<div class="card mb-4">
  <div class="card-header bg-success text-white">Berita Populer</div>
  <ul class="list-group list-group-flush">
    <?php
    $populer = $koneksi->query("SELECT idkonten, judulkonten FROM konten WHERE status='publik' ORDER BY tanggalbuat DESC LIMIT 5");
    while ($pop = $populer->fetch_assoc()) {
      echo '<li class="list-group-item">
              <a href="artikel/' . $pop['idkonten'] . '">' . htmlspecialchars($pop['judulkonten']) . '</a>
            </li>';
    }
    ?>
  </ul>
</div>

<div class="card">
  <div class="card-header bg-info text-white">Tag Populer</div>
  <div class="card-body">
    <span class="badge bg-secondary">Teknologi</span>
    <span class="badge bg-secondary">Pendidikan</span>
    <span class="badge bg-secondary">Kesehatan</span>
    <span class="badge bg-secondary">Ekonomi</span>
  </div>
</div>
