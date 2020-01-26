<?php

session_start();

require '../../start.php';

if (isset($_SESSION['user'])) {

    require_once BASE_DIR . '/db.php';

    $randomUrl      = md5(date("ymd") . time() . mt_rand(0,100000));

    //left sideber
    $leftSidebarName    = mysqli_real_escape_string($conn, $_POST['lsidebarname']);
    $leftSideber        = mysqli_real_escape_string($conn, $_POST['lsidebar']);

    //page content
    $pageName           = mysqli_real_escape_string($conn, $_POST['pagename']);
    $pageContent        = mysqli_real_escape_string($conn, $_POST['content']);

    //right sidebar
    $rightSidebarName   = mysqli_real_escape_string($conn, $_POST['rsidebarname']);
    $rightSidebar       = mysqli_real_escape_string($conn, $_POST['rsidebar']);

    //url, home and the id
    $homepage           = mysqli_real_escape_string($conn, $_POST['homepage']);
    //$url                = mysqli_real_escape_string($conn, $_POST['url']);
    //$post_page          = mysqli_real_escape_string($conn, $_POST['post']);
    $id                 = mysqli_real_escape_string($conn, $_POST['id']);


    if ($_POST['post'] === 'yes') {
        if (empty($_POST['url'])) {
            $post_page      = $randomUrl;
            $url            = $randomUrl;
        }
        else {
            $post_page      = mysqli_real_escape_string($conn, $_POST['url']);
            $url            = mysqli_real_escape_string($conn, $_POST['url']);
        }
    }
    else {
        if (empty($_POST['url'])) {
            $post_page      = '';
            $url            = $randomUrl;
        }
        else {
            $post_page      = '';
            $url            = mysqli_real_escape_string($conn, $_POST['url']);
        }
    }


    //update the database
    $update = "UPDATE page SET  pagename='$pageName',
                                content='$pageContent',
                                lsidebarname='$leftSidebarName',
                                rsidebarname='$rightSidebarName',
                                lsidebar='$leftSideber',
                                rsidebar='$rightSidebar',
                                home_page='$homepage',
                                url='$url',
                                post_page='$post_page'
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