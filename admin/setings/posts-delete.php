<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    function redirect() {
        header('Location: ' . ADMIN_URL . '/setings.php?command=pages');
    }

    if (isset($_GET['delete'])) {
        require BASE_DIR . '/db.php';
        $del        = $_GET['delete'];

        $sqlDelete  = "DELETE FROM posts WHERE id='$del'";

        if ($conn->query($sqlDelete) === TRUE) {
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