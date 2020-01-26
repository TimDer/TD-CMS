<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {
    $fileName               = $_FILES['upload-file']['name'];
    $fileTMP                = $_FILES['upload-file']['tmp_name'];
    $fileError              = $_FILES['upload-file']['error'];

    $extExplude             = explode('.', $fileName);
    $theExtName             = strtolower(end($extExplude));

    require BASE_DIR . "/db.php";
    $downloadSHA1           = sha1(time() . '?' . date('Y') . '$' . mt_rand(100000000,999999999));
    $downloadUploudSql      = "INSERT INTO downloads (the_file_name, sha1_download) VALUES ('$fileName', '$downloadSHA1')";
    $downloadUploudSqlQuery = mysqli_query($conn, $downloadUploudSql);

    $images                 = array('jpg', 'jpeg', 'png', 'gif');

    if (!in_array($theExtName, $images)) {
        if ($fileError === 0) {
            $fileDestination    = BASE_DIR . "/" . "downloads/" . $fileName;
            move_uploaded_file($fileTMP, $fileDestination);
            if ($downloadUploudSqlQuery) {
                header('Location: ' . ADMIN_URL . '/downloads.php');
            }
        }
        else {
            echo "error code: 2 <br><br>";
            echo "<pre>";
            var_dump($_FILES);
            echo "</pre>";
        }
    }
    else {
        echo "error code: 1";
        echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}