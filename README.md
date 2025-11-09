# CMSMAHDI

Sistem Manajemen Konten dua peran (Admin & Editor) buatan lokal 🇮🇩  
Dibangun dengan PHP murni dan struktur modular.

## 📂 Struktur Utama
- `dashboard.php` → pusat routing backend (admin & editor)
- `index.php` → pusat routing publik (landing)
- `includes/` → koneksi, fungsi, dan keamanan
- `views/` → semua tampilan (publik, admin, editor)
- `assets/` → CSS, JS, gambar
- `db/` → file SQL, backup, dan konfigurasi database

## 🧩 Fitur
- Multi-role (admin/editor)
- CRUD artikel, kategori, komentar
- Log aktivitas pengguna
- Sistem login dengan keamanan dasar
- Layout terpisah: publik dan backend

## ⚙️ Instalasi
1. Import file `db/cmsmahdi.sql` ke database MySQL
2. Ubah konfigurasi koneksi di `includes/koneksi.php`
3. Jalankan di browser: `http://localhost/cmsmahdi/`
4. Login dengan user:
   - **Username:** `adminmahdi`
   - **Password:** `admin123`

## 📜 Lisensi
Dibuat untuk keperluan belajar dan pengembangan internal.
