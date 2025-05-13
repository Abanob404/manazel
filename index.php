<?php
// public_html/index.php

// Include configuration
require_once __DIR__ . 
'/../config/config.php
';

// Include language loader
require_once __DIR__ . 
'/../includes/language.php
';

// Basic Router
$page = isset($_GET[
'page
']) ? $_GET[
'page
'] : 
'home
';

// Whitelist allowed pages to prevent directory traversal and other attacks
$allowed_pages = [
    'home',
    'about',
    'services',
    'listings',
    'property_details',
    'contact',
    'login',
    'register',
    'profile',
    'logout'
];

// Construct the path to the page template
$page_path = __DIR__ . 
'/../templates/pages/
' . $page . 
'.php
';

// Check if the page is allowed and the file exists
if (in_array($page, $allowed_pages) && file_exists($page_path)) {
    // Include header
    include_once __DIR__ . 
'/../templates/layouts/header.php
';

    // Include the requested page content
    include_once $page_path;

    // Include footer
    include_once __DIR__ . 
'/../templates/layouts/footer.php
';
} else {
    // Page not found or not allowed - show a 404 page
    // You can create a dedicated 404.php template for this
    http_response_code(404);
    include_once __DIR__ . 
'/../templates/layouts/header.php
'; // Optional: include header on 404
    echo 
'<div class="container"><p>
' . lang(
'error_404_message
') . 
'</p></div>
';
    include_once __DIR__ . 
'/../templates/layouts/footer.php
'; // Optional: include footer on 404
}

?>
