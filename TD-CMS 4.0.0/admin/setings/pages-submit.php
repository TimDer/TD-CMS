<?php

session_start();

require_once '../../start.php';

if (isset($_SESSION['user'])) {
    require BASE_DIR . '/db.php';

    function redirect() {
        header('Location: ' . ADMIN_URL . '/setings.php?command=pages');
    }

    if (isset($_POST['submit-button'])) {
        foreach  ($_POST['id'] AS $ID) {
            $theorder   = $_POST['theorder'][$ID];
            $home_page  = $_POST['homepage'][$ID];

            $sql = "UPDATE page SET theorder='$theorder',home_page='$home_page' WHERE id=$ID";

            $conn->query($sql);
        }

        foreach ($_POST['idPosts'] as $idPosts) {
            $category   = $_POST['category'][$idPosts];

            $sqlPosts   = "UPDATE posts SET category='$category' WHERE id='$idPosts'";

            $conn->query($sqlPosts);
        }

        redirect();
    }
    else {
        redirect();
    }

    redirect();
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}