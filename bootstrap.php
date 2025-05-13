<?php
// includes/bootstrap.php

// Ensure errors are shown during development
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define ROOT_PATH if not already defined (it should be defined in config.php, but as a fallback)
if (!defined("ROOT_PATH")) {
    define("ROOT_PATH", dirname(__DIR__)); // Assumes bootstrap.php is in /includes, so __DIR__ is /includes, dirname(__DIR__) is project root
}

// Load Configuration
if (file_exists(ROOT_PATH . "/config/config.php")) {
    require_once ROOT_PATH . "/config/config.php";
} else {
    die("FATAL ERROR: Configuration file not found. Please ensure config/config.php exists.");
}

// Load Core Helper Functions (including language functions)
if (file_exists(INCLUDES_PATH . "/functions.php")) {
    require_once INCLUDES_PATH . "/functions.php";
} else {
    die("FATAL ERROR: Core functions file not found. Please ensure includes/functions.php exists.");
}

// Autoloader for src/ classes (Simple PSR-4 style autoloader)
// For a more robust solution, consider using Composer's autoloader.
spl_autoload_register(function ($class_name) {
    // Replace namespace separators with directory separators
    $class_file = str_replace("\\", DIRECTORY_SEPARATOR, $class_name);
    
    // Prepend the src directory path
    $file = SRC_PATH . "/" . $class_file . ".php";

    if (file_exists($file)) {
        require_once $file;
    }
});

// Load the language array globally for easy access in templates
// The load_language() function is defined in functions.php
$lang = load_language();

// Database Connection (Example - to be replaced with a proper Database class later)
// For now, db.php might establish a connection or Database.php in Core might handle it.
if (file_exists(INCLUDES_PATH . "/db.php")) {
    require_once INCLUDES_PATH . "/db.php"; // This file would contain the actual DB connection logic
} elseif (file_exists(SRC_PATH . "/Core/Database.php")) {
    // If using a Database class, it might be instantiated here or when needed.
    // For example: $db = new Core\Database();
    // For now, we assume db.php or direct usage in models.
}

// Initialize Router (Example - to be replaced with a proper Router class later)
// The basic routing is currently in public_html/index.php, but a Router class in Core/Router.php would be better.

// Any other global initializations can go here.

?>
