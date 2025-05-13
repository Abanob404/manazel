<?php
// templates/layouts/header.php

// Ensure config and language are loaded (though index.php should handle this)
if (!defined(
'BASE_URL
')) {
    require_once __DIR__ . 
'/../../../config/config.php

';
}
if (!function_exists(

'lang

')) {
    require_once __DIR__ . 
'/../../../includes/language.php

';
}

$site_name = ($current_lang == 
'ar
') ? SITE_NAME_AR : SITE_NAME_EN;
$html_lang = $current_lang;
$html_dir = ($current_lang == 
'ar
') ? 
'rtl
' : 
'ltr
';

?>
<!DOCTYPE html>
<html lang="<?php echo $html_lang; ?>" dir="<?php echo $html_dir; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> - <?php echo isset($page_title) ? lang($page_title) : lang(
'home

'); ?></title>
    <!-- Basic CSS (You will replace this with your actual CSS files) -->
    <link rel="stylesheet" href="<?php echo base_url(
'assets/css/style.css

'); ?>">
    <?php if ($current_lang == 
'ar

'): ?>
        <!-- Link to RTL stylesheet if needed -->
        <!-- <link rel="stylesheet" href="<?php echo base_url(
'assets/css/style-rtl.css

'); ?>"> -->
    <?php endif; ?>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $site_name; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?php echo lang(
'toggle_navigation

'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(
'?page=home

'); ?>"><?php echo lang(
'home

'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(
'?page=about

'); ?>"><?php echo lang(
'about_us

'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(
'?page=listings

'); ?>"><?php echo lang(
'listings

'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(
'?page=services

'); ?>"><?php echo lang(
'services

'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(
'?page=contact

'); ?>"><?php echo lang(
'contact_us

'); ?></a>
                    </li>
                    <?php if (isset($_SESSION[
'user_id

'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(
'?page=profile

'); ?>"><?php echo lang(
'my_profile

'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(
'?page=logout

'); ?>"><?php echo lang(
'logout

'); ?></a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(
'?page=login

'); ?>"><?php echo lang(
'login

'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(
'?page=register

'); ?>"><?php echo lang(
'register

'); ?></a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo lang(
'language

'); ?> (<?php echo ($current_lang == 
'ar

') ? lang(
'arabic

') : lang(
'english

'); ?>)
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <?php
                            $lang_links = getLanguageSwitcherLinks();
                            foreach ($lang_links as $lang_code => $link) {
                                $lang_name = ($lang_code == 
'ar

') ? lang(
'arabic

') : lang(
'english

');
                                echo 
'<li><a class="dropdown-item" href="

' . $link . 
'">' . $lang_name . '</a></li>

';
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main class="container py-4">

