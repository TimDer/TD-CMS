<?php

function get_404() {
    if (isset($_GET['page'])) {
        if (file_exists(TEMP_DIR . '/404.php')) {
            require TEMP_DIR . '/404.php';
        }
        else {
            echo "<h1>404</h1>";
        }
    }
    elseif (isset($_GET['s'])) {
        if (file_exists(TEMP_DIR . '/search404.php')) {
            require TEMP_DIR . '/search404.php';
        }
        else {
            echo "<h1>404</h1>";
        }
    }
}