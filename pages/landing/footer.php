<?php
// ==============================================
// File: pages/landing/footer.php
// Deskripsi: Footer publik
// ==============================================
?>
<footer class="bg-dark text-light text-center py-4 mt-5">
  <div class="container">
    <small>&copy; <?= date('Y'); ?> <?= $site_name; ?> — Portal Berita by <?= $penulis; ?></small>
  </div>
</footer>
<script src="<?= BASE_URL; ?>/asset/dist/js/adminlte.min.js"></script>
<script src="<?= BASE_URL; ?>/asset/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?= url('asset/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= url('asset/js/landing.js'); ?>"></script>
</body>
</html>
