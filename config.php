<?php
// config.php

// Site Settings
define('SITE_NAME_EN', 'Manazel Real Estate');
define('SITE_NAME_AR', 'منازل العقارية');
define('BASE_URL', 'http://localhost/manazel_php_project/public_html'); // Adjust if you deploy to a different URL

// Database Configuration (MySQL)
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user'); // Replace with your database username
define('DB_PASS', 'your_db_password'); // Replace with your database password
define('DB_NAME', 'manazel_db'); // Replace with your database name

// Language Settings
define('DEFAULT_LANG', 'en');
$supported_langs = ['en', 'ar'];

// Error Reporting (for development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to get current language
function getCurrentLang() {
    global $supported_langs;
    if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $supported_langs)) {
        return $_SESSION['lang'];
    }
    if (isset($_GET['lang']) && in_array($_GET['lang'], $supported_langs)) {
        $_SESSION['lang'] = $_GET['lang'];
        return $_GET['lang'];
    }
    return DEFAULT_LANG;
}

$current_lang = getCurrentLang();

// Autoload classes (if you plan to use OOP extensively)
// spl_autoload_register(function ($class_name) {
//     $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class_name) . '.php';
//     if (file_exists($file)) {
//         require_once $file;
//     }
// });

// Helper function for base URL
function base_url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

?>
