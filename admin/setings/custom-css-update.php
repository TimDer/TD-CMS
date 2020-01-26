<?php

session_start();

require '../../start.php';

if (isset($_SESSION['user'])) {
    require BASE_DIR . '/db.php';

    $customCss    = $_POST['custom-css'];

    $sql       = "UPDATE settings SET customcss='$customCss'";

    if (mysqli_query($conn, $sql)) {
        header('Location: ' . ADMIN_URL . '/setings.php?command=custom-css&update=1');
    }
    else {
        header('Location: ' . ADMIN_URL . '/setings.php?command=custom-css&error=1');
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}