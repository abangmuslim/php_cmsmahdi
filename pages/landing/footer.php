<?php
// ==============================================
// File: pages/landing/footer.php
// Deskripsi: Footer portal berita CMSMAHDI
// ==============================================
?>
<footer class="text-center py-4 mt-5">
  <div class="container">
    <div class="mb-3">
      <a href="#"><i class="fab fa-facebook-f mx-2"></i></a>
      <a href="#"><i class="fab fa-instagram mx-2"></i></a>
      <a href="#"><i class="fab fa-youtube mx-2"></i></a>
      <a href="#"><i class="fab fa-tiktok mx-2"></i></a>
    </div>
    <p class="mb-0 small">&copy; <?= date('Y'); ?> <?= htmlspecialchars($site_name); ?>. 
      Semua hak dilindungi. <br>
      <span class="text-light">Dikelola oleh Pemerintah Kabupaten Asahan.</span>
    </p>
  </div>
</footer>

<!-- JS: jQuery, Bootstrap, AdminLTE -->
<!-- JS: jQuery harus duluan -->
<script src="<?= BASE_URL; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?= BASE_URL; ?>/asset/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL; ?>/asset/dist/js/adminlte.min.js"></script>


</div> <!-- wrapper -->
</body>
</html>

