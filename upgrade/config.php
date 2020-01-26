<?php

//DIR
if (isset($_POST['installationDirectory'])) {
    if (empty($_POST['installationDirectory'])) {
        define('BASE_DIR', __dir__ . '/..');
    }
    else {
        define('BASE_DIR', __dir__ . '/..' . $_POST['installationDirectory']);
    }
}
else {
    define('BASE_DIR', __dir__ . '/..');
}
define('UPGRADE_DIR', __DIR__);
define('ROOT_DIR', __DIR__ . '/..');

//URL
if (isset($_SERVER['HTTPS'])) {
    define('PROTOCOL', 'https://');
} else {
    define('PROTOCOL', 'http://');
}
define('URL', $_SERVER['HTTP_HOST']);
define('BASE_URL', PROTOCOL . URL);
define('UPGRADE_URL', BASE_URL . '/upgrade');

if (isset($_GET['installDir'])) {
    if ($_GET['installDir'] !== 'root') {
        define('ADMIN_URL', BASE_URL . $_GET['installDir'] . '/admin');
    }
    else {
        define('ADMIN_URL', BASE_URL . '/admin');
    }
}