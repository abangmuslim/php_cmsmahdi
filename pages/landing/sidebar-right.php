<div class="card mb-4">
  <div class="card-header bg-success text-white">Berita Populer</div>
  <ul class="list-group list-group-flush">
    <?php
    $populer = $koneksi->query("SELECT idkonten, judulkonten FROM konten WHERE status='publik' ORDER BY tanggalbuat DESC LIMIT 5");
    while ($pop = $populer->fetch_assoc()) {
        echo '<li class="list-group-item">
                <a href="' . BASE_URL . 'index.php?hal=detilkonten&id=' . $pop['idkonten'] . '" class="text-decoration-none">'
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
    // Ambil semua tag dari konten publik
    $query = "SELECT tag FROM konten WHERE status='publik' AND tag IS NOT NULL AND tag != ''";
    $result = mysqli_query($koneksi, $query);
    $all_tags = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $tags = array_map('trim', explode(',', $row['tag']));
        $all_tags = array_merge($all_tags, $tags);
    }

    $unique_tags = array_unique($all_tags);
    $colors = ['primary','secondary','success','danger','warning','info','dark'];

    if (!empty($unique_tags)) {
        foreach ($unique_tags as $tag) {
            $color = $colors[array_rand($colors)];
            // URL menggunakan id=tag agar bisa di-handle di kategori.php
            echo '<a href="' . BASE_URL . 'kategori?id=' . urlencode($tag) . '" 
                    class="badge bg-' . $color . ' me-1 mb-1 text-decoration-none">'
                  . htmlspecialchars($tag) .
                 '</a>';
        }
    } else {
        echo '<span class="text-muted">Belum ada tag</span>';
    }
    ?>
  </div>
</div>
