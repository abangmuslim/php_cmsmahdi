<?php
// ===============================================
// File: includes/path.php
// Deskripsi: Definisi path absolut dan URL dasar untuk CMS Mahdi
// ===============================================

// Gunakan realpath agar kompatibel Windows & Linux
$root_path = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR;

// Path absolut
define('BASE_PATH', $root_path);
define('INCLUDES_PATH', BASE_PATH . 'includes' . DIRECTORY_SEPARATOR);
define('PAGES_PATH', BASE_PATH . 'pages' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', BASE_PATH . 'views' . DIRECTORY_SEPARATOR);
define('UPLOADS_PATH', BASE_PATH . 'uploads' . DIRECTORY_SEPARATOR);

// URL dasar (BASE_URL) hanya didefinisikan jika belum ada
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/cmsmahdi/');
}

// Folder upload spesifik
define('UPLOAD_USER', UPLOADS_PATH . 'user' . DIRECTORY_SEPARATOR);
define('UPLOAD_KONTEN', UPLOADS_PATH . 'konten' . DIRECTORY_SEPARATOR);
define('UPLOAD_KOMENTAR', UPLOADS_PATH . 'komentar' . DIRECTORY_SEPARATOR);
?>
