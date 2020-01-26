<?php

session_start();

require '../../start.php';

if (isset($_SESSION['user'])) {

    require_once BASE_DIR . '/db.php';

    //left sideber
    $leftSidebarName    = $_POST['lsidebarname'];
    $leftSideber        = $_POST['lsidebar'];

    //page content
    $pageName           = $_POST['pagename'];
    $pageContent        = $_POST['content'];

    //right sidebar
    $rightSidebarName   = $_POST['rsidebarname'];
    $rightSidebar       = $_POST['rsidebar'];

    //url, home and the id
    $homepage           = $_POST['homepage'];
    $url                = $_POST['url'];
    $id                 = $_POST['id'];

    //update the database
    $update = "UPDATE page SET  pagename='$pageName',
                                content='$pageContent',
                                lsidebarname='$leftSidebarName',
                                rsidebarname='$rightSidebarName',
                                lsidebar='$leftSideber',
                                rsidebar='$rightSidebar',
                                home_page='$homepage',
                                url='$url'
                                WHERE id = '$id'";

    if ($conn->query($update)) {
        if (isset($_POST['submit-save-and-exit-button'])) {
            header('Location: ' . ADMIN_URL . '/edit-pages.php');
        }
        else {
            header('Location: ' . ADMIN_URL . '/edit-pages.php?edit=' . $id);
        }
    }
    else {
        echo 'error with: ' . $conn->error;
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}