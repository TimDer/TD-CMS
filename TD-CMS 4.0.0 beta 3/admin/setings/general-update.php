<?php 

session_start();

require '../../start.php';

if (isset($_SESSION['user'])) {
    if (!empty($_POST['sidename']) AND !empty($_POST['sideslug'])) {
        $sidename   = $_POST['sidename'];
        $sideslug   = $_POST['sideslug'];
        $id         = $_POST['id'];

        require BASE_DIR . '/db.php';

        $sql = "UPDATE settings SET sidename='$sidename',sideslug='$sideslug' WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            header('Location: ' . ADMIN_URL . '/setings.php?command=general&update=1');
        }
        else {
            echo 'Error: ' . $conn->error;
        }
    }
    else {
        header('Location: ' . ADMIN_URL . '/setings.php?command=general&error=1');
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}