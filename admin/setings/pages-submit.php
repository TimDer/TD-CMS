<?php

session_start();

require_once '../../start.php';

if (isset($_SESSION['user'])) {
    require_once BASE_DIR . '/db.php';

    foreach  ($_POST['id'] AS $ID) {
        $theorder   = $_POST['theorder'][$ID];
        $home_page  = $_POST['homepage'][$ID];

        $sql = "UPDATE page SET theorder='$theorder',home_page='$home_page' WHERE id=$ID";

        $conn->query($sql);
    }

    header('Location: ' . ADMIN_URL . '/setings.php?command=pages');
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}