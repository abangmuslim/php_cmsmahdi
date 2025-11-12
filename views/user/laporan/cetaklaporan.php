<?php
// ======================================================
// File: views/user/laporan/cetaklaporan.php
// Deskripsi: Halaman cetak laporan konten berdasarkan tanggal
// ======================================================

require_once __DIR__ . '/../../../includes/path.php'; // ✅ FIX: naik 3 tingkat ke root cmsmahdi
require_once INCLUDES_PATH . 'konfig.php';
require_once INCLUDES_PATH . 'koneksi.php';
require_once INCLUDES_PATH . 'ceksession.php';

// Ambil parameter tanggal
$tgl_mulai = $_GET['tgl_mulai'] ?? '';
$tgl_selesai = $_GET['tgl_selesai'] ?? '';

// Query data sesuai filter
$sql = "SELECT k.judulkonten, k.tag, c.namakategori, u.namauser, k.tanggalbuat, k.status
        FROM konten k
        LEFT JOIN kategori c ON k.idkategori = c.idkategori
        LEFT JOIN user u ON k.iduser = u.iduser";

if ($tgl_mulai && $tgl_selesai) {
    $sql .= " WHERE DATE(k.tanggalbuat) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
}

$sql .= " ORDER BY k.tanggalbuat DESC";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Konten</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .info {
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .right {
            text-align: right;
        }

        .print-button {
            display: flex;
            justify-content: center;
            /* ✅ ini membuat tombol di tengah */
            gap: 10px;
            margin: 15px 0;
        }

        .print-button button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .print-button .btn-print {
            background-color: #007bff;
            color: #fff;
        }

        .print-button .btn-close {
            background-color: #dc3545;
            color: #fff;
        }

        @media print {
            .print-button {
                display: none;
            }
        }

        .tanda-tangan {
            width: 250px;
            float: right;
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
        }

        .tanda-tangan p {
            margin: 3px 0;
        }

        .tanda-tangan .nama {
            font-weight: bold;
            font-size: 14px;
            /* lebih besar dari teks biasa */
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="print-button">
        <button class="btn-print" onclick="window.print();"><i>🖨</i> Cetak</button>
        <button class="btn-close" onclick="window.close();"><i>❌</i> Tutup</button>
    </div>

    <h2>Laporan CMS Ahmadi Muslim</h2>
    <h4>Laporan Data Konten</h4>
    <?php if ($tgl_mulai && $tgl_selesai): ?>
        <p class="info"><strong>Periode:</strong> <?= date('d-m-Y', strtotime($tgl_mulai)) ?> s.d <?= date('d-m-Y', strtotime($tgl_selesai)) ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Konten</th>
                <th>Kategori</th>
                <th>Tag</th>
                <th>Pembuat</th>
                <th>Status</th>
                <th>Tanggal Posting</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                      <td>{$no}</td>
                      <td>{$row['judulkonten']}</td>
                      <td>{$row['namakategori']}</td>
                      <td>{$row['tag']}</td>
                      <td>{$row['namauser']}</td>
                      <td>" . ucfirst($row['status']) . "</td>
                      <td>" . date('d-m-Y', strtotime($row['tanggalbuat'])) . "</td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='7' class='right'><em>Tidak ada data untuk periode ini.</em></td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Lokasi dan tanggal otomatis
    $lokasi = "Karang Baru";
    $tanggal_sekarang = date('d F Y');
    ?>
    <div class="tanda-tangan">
        <p><?= $lokasi; ?>, <?= $tanggal_sekarang; ?></p>
        <p>Admin Kepala,</p>
        <br><br><br>
        <p class="nama">Ahmadi Muslim, MP</p>
        <p>NIP. </p>
    </div>


</body>

</html>