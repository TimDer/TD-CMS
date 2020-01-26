<?php

//this file is used to delete pages

session_start();

require '../../start.php';

if (isset($_SESSION['user'])) {
    require_once BASE_DIR . '/db.php';

    function redirect() {
        header('Location: ' . ADMIN_URL . '/setings.php?command=pages');
    }

    if (isset($_GET['del-page'])) {
        $del = $_GET['del-page'];

        $sql = "DELETE FROM page WHERE id=$del";

        if ($conn->query($sql) === TRUE) {
            redirect();
        }
        else {
            echo 'Error: ' . $conn->error;
        }
    }
    else {
        redirect();
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}