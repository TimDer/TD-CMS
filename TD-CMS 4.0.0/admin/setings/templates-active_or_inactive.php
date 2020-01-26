<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {
    require BASE_DIR . '/db.php';

    $idPermission = $_SESSION['id'];
    
    $sqlUserid      = "SELECT * FROM users WHERE id='$idPermission'";
    $queryUserid    = mysqli_query($conn, $sqlUserid);
    
    if ($queryUserid->num_rows > 0) {
        if ($rowPermission = mysqli_fetch_assoc($queryUserid)) {
            if ($rowPermission['set_template'] === 'yes') {
                if (isset($_GET['id'])) {
                    // veriables
                    $templateActivateOrDeadtivateID     = mysqli_real_escape_string($conn, $_GET['id']);
                    $templateDeadtivateSql              = "UPDATE templates SET active_or_inactive='inactive'";

                    // Deadtivate all
                    if (mysqli_query($conn, $templateDeadtivateSql)) {
                        $templateActivateSql            = "UPDATE templates SET active_or_inactive='active' WHERE id='$templateActivateOrDeadtivateID'";
                        $templateActivateSqlQuery       = mysqli_query($conn, $templateActivateSql);
                        
                        if ($templateActivateSqlQuery) {
                            header('Location: ' . ADMIN_URL . '/setings.php?command=templates&activetedTemplateID=' . $templateActivateOrDeadtivateID);
                        }
                    }
                    else {
                        echo 'error 1';
                    }
                }
            }
        }
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}