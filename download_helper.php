<?php

if (isset($_GET['download_id'])) {
    require "start.php";
    require BASE_DIR . "/db.php";
    
    $downloadFile           = $_GET['download_id'];
    $downloadFileSql        = "SELECT * FROM downloads WHERE sha1_download='$downloadFile'";
    $downloadFileSqlQuery   = mysqli_query($conn, $downloadFileSql);
    
    if ($downloadFileSqlQuery->num_rows > 0) {
        if ($row = mysqli_fetch_assoc($downloadFileSqlQuery)) {
            $downloadFile_name  = $row['the_file_name'];
            header('Location: ' . BASE_URL . '/download_files/' . $downloadFile_name);
        }
    }
}