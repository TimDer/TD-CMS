<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    if (isset($_POST['yes'])) {
        require BASE_DIR . "/db.php";
        $delete_downloadFile        = $_GET['delete'];
        
        $getDownloadFileSql         = "SELECT * FROM downloads WHERE sha1_download='$delete_downloadFile'";
        $getDownloadFileSqlQuery    = mysqli_query($conn, $getDownloadFileSql);

        if ($getDownloadFileSqlQuery->num_rows > 0) {
            if ($rowGetDelete = mysqli_fetch_assoc($getDownloadFileSqlQuery)) {
                $fileToDelete   = BASE_DIR . "/" . "downloads/" . $rowGetDelete['the_file_name'];
                if (unlink($fileToDelete)) {
                    $databaseDataDeleteSql      = "DELETE FROM downloads WHERE sha1_download='$delete_downloadFile'";
                    $databaseDataDeleteSqlQuery = mysqli_query($conn, $databaseDataDeleteSql);
                    if ($databaseDataDeleteSqlQuery) {
                        header('Location: ' . ADMIN_URL . '/downloads.php');
                    }
                    else {
                        echo "Error 2 has occurred";
                    }
                }
                else {
                    echo "Error 1 has occurred";
                }
            }
        }
        else {
            header('Location: ' . ADMIN_URL . '/downloads.php');
        }
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>