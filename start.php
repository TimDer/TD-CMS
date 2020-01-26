<?php

//DIR
define('BASE_DIR', __dir__);
define('ADMIN_DIR', BASE_DIR . '/admin');
define('TEMP_DIR', BASE_DIR . '/template');

//URL
if (isset($_SERVER['HTTPS'])) {
    define('PROTOCOL', 'https://');
} else {
    define('PROTOCOL', 'http://');
}
//define('BASE_URL', PROTOCOL . 'localhost:8080');
define('URL', $_SERVER['HTTP_HOST']);
define('BASE_URL', PROTOCOL . URL);
define('ADMIN_URL', BASE_URL . '/admin');
define('TEMP_URL', BASE_URL . '/template');

$start = 1;