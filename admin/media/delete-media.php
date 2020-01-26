<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {
    // sql
    require BASE_DIR . "/db.php";
    $mediaDeleteId      = $_GET['id'];
    $mediaSql           = "SELECT * FROM media WHERE id='$mediaDeleteId'";
    $mediaSqlQuery      = mysqli_query($conn, $mediaSql);

    if ($mediaSqlQuery->num_rows > 0) {
        if ($rows = mysqli_fetch_assoc($mediaSqlQuery)) {
            $theFileName    = $rows['the_file_name'];
            $deleteTheFile  = BASE_DIR . "/" . "images/" . $theFileName;

            unlink($deleteTheFile);

            $mediaDeleteSql         = "DELETE FROM media WHERE id='$mediaDeleteId'";
            $mediaDeleteSqlQuery    = mysqli_query($conn, $mediaDeleteSql);

            if ($mediaDeleteSqlQuery) {
                header('Location: ' . ADMIN_URL . '/media.php');
            }
            else {
                echo "error: " . $conn->error;
            }
        }
    }
    else {
        header('Location: ' . ADMIN_URL . '/media.php');
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}