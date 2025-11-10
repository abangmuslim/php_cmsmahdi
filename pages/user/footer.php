<?php
// ==============================================
// File: pages/user/footer.php
// Deskripsi: Footer dan script JS admin CMSMAHDI
// ==============================================
?>
<footer class="main-footer text-center">
  <strong>&copy; <?= date('Y'); ?> <?= $site_name; ?></strong> — Dashboard Admin
</footer>

</div> <!-- end of .wrapper -->

<!-- JS AdminLTE & Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= url('asset/dist/js/jquery.min.js'); ?>"></script>
<script src="<?= url('asset/dist/js/bootstrap.bundle.min.js'); ?>"></script> <!-- Sudah termasuk Popper.js -->
<script src="<?= url('asset/dist/js/adminlte.min.js'); ?>"></script>
<script src="<?= url('asset/js/custom.js'); ?>"></script> <!-- opsional: script tambahan -->
</body>
</html>