<?php

/*
    DO NOT CHANGE LINES IN THIS FILE IF THE CMS IS NOT YET INSTALLED
    OR IF YOUR PLANNING TO REINSTALL THE CMS

    start.php is the config file of TD-CMS
*/

// DIR
define('BASE_DIR', __dir__);
define('ADMIN_DIR', BASE_DIR . '/admin');

if (file_exists(BASE_DIR . "/db.php")) {
    require BASE_DIR . "/db.php";
    $startTemplateSql           = "SELECT * FROM templates WHERE active_or_inactive='active'";
    $startTemplateSqlQueryDIR   = mysqli_query($conn, $startTemplateSql);
    if (mysqli_num_rows($startTemplateSqlQueryDIR) > 0) {
        if ($startTemplateRow = mysqli_fetch_assoc($startTemplateSqlQueryDIR)) {
            define('TEMP_DIR', BASE_DIR . '/template/' . $startTemplateRow['folder_name']);
        }
    }
    else {
        define('TEMP_DIR', BASE_DIR . '/template');
    }
}

// Create the base URL
if (isset($_SERVER['HTTPS'])) {
    define('PROTOCOL', 'https://');
} else {
    define('PROTOCOL', 'http://');
}
define('URL', $_SERVER['HTTP_HOST']);
define('URL_DIR', '');

// URL
define('BASE_URL', PROTOCOL . URL . URL_DIR);
define('ADMIN_URL', BASE_URL . '/admin');

if (file_exists(BASE_DIR . "/db.php")) {
    $startTemplateSqlQueryURL   = mysqli_query($conn, $startTemplateSql);
    if (mysqli_num_rows($startTemplateSqlQueryURL) > 0) {
        if ($startTemplateRow = mysqli_fetch_assoc($startTemplateSqlQueryURL)) {
            define('TEMP_URL', BASE_URL . '/template/' . $startTemplateRow['folder_name']);
        }
    }
    else {
        define('TEMP_URL', BASE_URL . '/template');
    }
    $conn->close();
}
$start = 1;