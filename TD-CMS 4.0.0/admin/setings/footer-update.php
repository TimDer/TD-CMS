<?php

session_start();

require '../../start.php';

if (isset($_SESSION['user'])) {
    require BASE_DIR . '/db.php';

    $footer         = $_POST['footer'];
    $footerClass    = $_POST['footer-class'];

    $sql       = "UPDATE settings SET footer='$footer',footerclass='$footerClass'";

    if (mysqli_query($conn, $sql)) {
        header('Location: ' . ADMIN_URL . '/setings.php?command=footer&update=1');
    }
    else {
        header('Location: ' . ADMIN_URL . '/setings.php?command=footer&error=1');
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}