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
                    require ADMIN_DIR . "/functions.php";

                    $templateid             = $_GET['id'];
    
                    $templateDeleteSql      = "SELECT * FROM templates WHERE id='$templateid'";
                    $templateDeleteSqlQuery = mysqli_query($conn, $templateDeleteSql);
    
                    if (mysqli_num_rows($templateDeleteSqlQuery) > 0) {
                        if ($templateDeleteRow = mysqli_fetch_assoc($templateDeleteSqlQuery)) {
                            // veriables
                            $theTemplateDirectory       = $templateDeleteRow['folder_name'];
                            $templateDeleteTheSql       = "DELETE FROM templates WHERE id='$templateid'";
                            $templateDeleteTheSqlQuery  = mysqli_query($conn, $templateDeleteTheSql);
    
                            // delete the sql
                            if ($templateDeleteTheSqlQuery) {
                                // delete the template
                                deleteDirectory(BASE_DIR . "/template/" . $theTemplateDirectory);
                                header('Location: ' . ADMIN_URL . '/setings.php?command=templates');
                            }
                            else {
                                echo 'error 3';
                                die();
                            }
                        }
                        else {
                            echo 'error 2';
                            die();
                        }
                    }
                    else {
                        echo 'error 1';
                        die();
                    }
                }
            }
        }
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}