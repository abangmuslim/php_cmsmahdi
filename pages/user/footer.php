<?php
// ==============================================
// File: pages/user/footer.php
// Deskripsi: Footer & script plugin untuk Admin CMS Mahdi
// ==============================================
?>
  </div> <!-- /.wrapper -->

  <!-- jQuery -->
  <script src="<?= BASE_URL ?>asset/plugins/jquery/jquery.min.js"></script>

  <!-- Bootstrap -->
  <script src="<?= BASE_URL ?>asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- AdminLTE -->
  <script src="<?= BASE_URL ?>asset/dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="<?= BASE_URL ?>asset/plugins/datatables/datatables.min.js"></script>

  <!-- Summernote -->
  <script src="<?= BASE_URL ?>asset/plugins/summernote/summernote-bs4.min.js"></script>

  <!-- ChartJS -->
  <script src="<?= BASE_URL ?>asset/plugins/chartjs/chart.min.js"></script>

  <!-- FontAwesome -->
  <script src="<?= BASE_URL ?>asset/plugins/fontawesome/js/all.min.js"></script>

  <!-- Inisialisasi umum -->
  <script>
    $(document).ready(function () {
      // Aktifkan DataTables
      $('.datatable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
          url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
        }
      });

      // Tooltip FontAwesome
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

  <script src="asset/pluggin/summernote/summernote-bs4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.summernote').summernote({
        height: 250,
        toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview']]
        ]
      });
    });
  </script>

  <!-- Penyesuaian otomatis padding-top agar tidak overlapping saat navbar autohide -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const navbar = document.querySelector('.main-header');
      const body = document.body;

      function adjustPadding() {
        const navbarHeight = navbar ? navbar.offsetHeight : 0;
        body.style.paddingTop = navbarHeight + 'px';
      }

      // Jalankan saat halaman dimuat
      adjustPadding();

      // Jalankan juga setiap kali jendela diresize
      window.addEventListener('resize', adjustPadding);

      // Jalankan juga saat tinggi navbar berubah (misal autohide aktif)
      let lastHeight = navbar ? navbar.offsetHeight : 0;
      setInterval(() => {
        if (navbar && navbar.offsetHeight !== lastHeight) {
          lastHeight = navbar.offsetHeight;
          adjustPadding();
        }
      }, 300);
    });
  </script>

</body>
</html>
