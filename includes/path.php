<?php
// ===============================================
// File: includes/path.php
// Deskripsi: Definisi path absolut untuk seluruh sistem CMSMAHDI
// ===============================================

// Gunakan realpath agar kompatibel di Windows & Linux
$root_path = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR;

define('BASE_PATH', $root_path);
define('INCLUDES_PATH', BASE_PATH . 'includes' . DIRECTORY_SEPARATOR);
define('PAGES_PATH', BASE_PATH . 'pages' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', BASE_PATH . 'views' . DIRECTORY_SEPARATOR);
define('UPLOADS_PATH', BASE_PATH . 'uploads' . DIRECTORY_SEPARATOR);
