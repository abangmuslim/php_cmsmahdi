<?php
// ==============================================
// File: views/user/konten/tambahkonten.php
// ==============================================

require_once __DIR__ . '/../../../includes/path.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1><i class="fas fa-file-alt"></i> Tambah Konten</h1>
  </section>

  <section class="content">
    <div class="card card-success">
      <div class="card-header bg-gradient-success d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-plus-circle"></i> Form Tambah Konten</h3>
      </div>

      <form action="views/user/konten/proseskonten.php" method="POST" enctype="multipart/form-data">
        <div class="card-body">
          <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-8">
              <div class="form-group">
                <label>Judul Konten</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul konten" required>
              </div>

              <div class="form-group">
                <label>Isi Konten</label>
                <textarea name="isi" class="form-control summernote" rows="10" required></textarea>
              </div>

              <div class="form-group">
                <label>Kategori</label>
                <div class="input-group">
                  <select id="idkategori" name="idkategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    $res = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY namakategori ASC");
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<option value='{$row['idkategori']}'>" . htmlspecialchars($row['namakategori']) . "</option>";
                    }
                    ?>
                  </select>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#modalTambahKategori">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Tag (pisahkan dengan koma)</label>
                <input type="text" name="tag" class="form-control" placeholder="contoh: pendidikan, teknologi">
              </div>

              <div class="form-group mt-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                  <option value="draft">Draft</option>
                  <option value="publik" selected>Publik</option>
                </select>
              </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-4 text-center">
              <div class="form-group">
                <label>Gambar Konten</label><br>
                <input type="file" name="gambar" id="gambarInput" class="form-control-file" accept=".jpg,.jpeg,.png,.gif,.webp">
                <small class="form-text text-muted">Maks 2MB</small>
                <img id="previewGambar" src="uploads/konten/default.png" class="img-thumbnail mt-2" width="250">
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer text-right">
          <a href="dashboard.php?hal=konten/daftarkonten" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
          <button type="reset" class="btn btn-warning btn-sm"><i class="fas fa-retweet"></i> Reset</button>
          <button type="submit" name="aksi" value="tambah" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </section>
</div>

<!-- =======================
MODAL TAMBAH KATEGORI
======================= -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white py-2">
        <h5 class="modal-title mb-0" id="modalTambahKategoriLabel"><i class="fas fa-plus-circle"></i> Tambah Kategori</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-2">
          <label>Nama Kategori</label>
          <input type="text" id="kategoriBaru" class="form-control form-control-sm" placeholder="Masukkan nama kategori">
        </div>
        <div class="form-group mb-0">
          <label>Deskripsi (opsional)</label>
          <textarea id="deskripsiKategori" class="form-control form-control-sm" rows="2" placeholder="Deskripsi singkat"></textarea>
        </div>
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
        <button type="button" id="btnSimpanKategori" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- =======================
SCRIPT TAMBAHAN
======================= -->
<script>
// Preview gambar
document.getElementById('gambarInput').addEventListener('change', function(e){
  const file = e.target.files[0];
  if(file){
    const reader = new FileReader();
    reader.onload = function(ev){
      document.getElementById('previewGambar').src = ev.target.result;
    }
    reader.readAsDataURL(file);
  }
});

// Tambah kategori via AJAX
document.getElementById('btnSimpanKategori').addEventListener('click', function(){
  const nama = document.getElementById('kategoriBaru').value.trim();
  const desk = document.getElementById('deskripsiKategori').value.trim();

  if (nama === '') {
    alert('Nama kategori tidak boleh kosong!');
    return;
  }

  fetch('views/user/konten/proseskonten.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'aksi=tambah_kategori_ajax&namakategori=' + encodeURIComponent(nama) + '&deskripsi=' + encodeURIComponent(desk)
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'sukses') {
      const select = document.getElementById('idkategori');
      const option = new Option(data.namakategori, data.idkategori, true, true);
      select.add(option);

      // Reset dan tutup modal
      document.getElementById('kategoriBaru').value = '';
      document.getElementById('deskripsiKategori').value = '';
      $('#modalTambahKategori').modal('hide');
    } else {
      alert(data.pesan || 'Gagal menambah kategori.');
    }
  })
  .catch(err => {
    console.error(err);
    alert('Terjadi kesalahan koneksi.');
  });
});
</script>
