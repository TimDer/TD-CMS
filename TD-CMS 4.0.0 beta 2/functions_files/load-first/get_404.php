<?php

function get_404() {
    if (isset($_GET['page'])) {
        require TEMP_DIR . '/404.php';
    }
    elseif (isset($_GET['s'])) {
        require TEMP_DIR . '/search404.php';
    }
}