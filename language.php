<?php
// includes/language.php

// This file is included by public_html/index.php after config.php
// $current_lang is already defined in config.php

$lang_data = [];

function loadLanguageData($lang_code) {
    global $lang_data;
    $lang_file_path = __DIR__ . 
'/../lang/
' . $lang_code . 


'.php


';
    if (file_exists($lang_file_path)) {
        $lang_data = require $lang_file_path;
    } else {
        // Fallback to default language if the specified language file doesn't exist
        $default_lang_file_path = __DIR__ . 
'/../lang/
' . DEFAULT_LANG . 


'.php


';
        if (file_exists($default_lang_file_path)) {
            $lang_data = require $default_lang_file_path;
        }
    }
}

// Load the language data for the current language
loadLanguageData($current_lang);

// Function to get a translated string
function lang($key, $default_value = 
''
) {
    global $lang_data;
    if (isset($lang_data[$key])) {
        return $lang_data[$key];
    }
    // Optionally, log missing keys or return a placeholder
    // error_log("Missing language key: " . $key . " for language: " . $GLOBALS[
'current_lang
']);
    return $default_value ?: $key; // Return the key itself or a default if not found
}

// Function to generate language switcher links
function getLanguageSwitcherLinks($current_page_params = []) {
    global $supported_langs;
    $links = [];
    $base_url = strtok($_SERVER[
"REQUEST_URI"
], 
'?
'); // Get current script path without query string

    foreach ($supported_langs as $lang_code) {
        $query_params = $_GET; // Get current query parameters
        $query_params[
'lang
'] = $lang_code; // Set or override the lang parameter
        
        // Preserve other existing GET parameters
        if (!empty($current_page_params)) {
            $query_params = array_merge($query_params, $current_page_params);
        }
        
        $links[$lang_code] = $base_url . 
'?
' . http_build_query($query_params);
    }
    return $links;
}

?>
