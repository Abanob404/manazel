<?php 
// templates/layouts/admin_layout.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once dirname(__FILE__) . 
'/../../includes/functions.php
';
$lang = load_language(); // Ensure language is loaded

// Admin Authentication Check - Placeholder
// if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== "admin") {
//     header("Location: " . SITE_URL . "/login"); // Redirect to login if not admin
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION["lang"]) ? $_SESSION["lang"] : DEFAULT_LANGUAGE; ?>" dir="<?php echo (isset($_SESSION["lang"]) && $_SESSION["lang"] == "ar") ? "rtl" : "ltr"; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo trans("admin_panel"); ?> - <?php echo trans("site_title"); ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css"> 
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin_style.css"> <!-- Specific admin styles -->
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <a href="<?php echo SITE_URL; ?>/admin/dashboard.php"><?php echo trans("admin_panel"); ?></a>
            </div>
            <nav class="admin-nav">
                <ul>
                    <li><a href="<?php echo SITE_URL; ?>/admin/dashboard.php"><?php echo trans("nav_dashboard"); ?></a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/manage-properties.php"><?php echo trans("nav_manage_properties"); ?></a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/manage-users.php"><?php echo trans("nav_manage_users"); ?></a></li>
                    <li><a href="<?php echo SITE_URL; ?>"><?php echo trans("go_home_button"); // Link back to frontend ?></a></li>
                    <li><a href="<?php echo SITE_URL; ?>/logout.php"><?php echo trans("nav_logout"); ?></a></li>
                </ul>
            </nav>
        </aside>
        <main class="admin-main-content">
            <header class="admin-header">
                <h1><?php echo isset($page_title) ? e($page_title) : trans("admin_dashboard_title"); ?></h1>
                <div class="language-switcher">
                    <a href="?lang=en">EN</a> | <a href="?lang=ar">AR</a>
                </div>
            </header>
            <div class="admin-page-content">

