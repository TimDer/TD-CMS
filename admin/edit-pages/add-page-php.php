<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    require BASE_DIR . "/db.php";

    if (isset($_POST['content']) AND isset($_POST['pagename'])) {
        // content
        $content        = mysqli_real_escape_string($conn, $_POST['content']);
        $pagename       = mysqli_real_escape_string($conn, $_POST['pagename']);

        // left sideber
        $lsidebarname   = mysqli_real_escape_string($conn, $_POST['lsidebarname']);
        $lsidebar       = mysqli_real_escape_string($conn, $_POST['lsidebar']);

        // right sidebar
        $rsidebarname   = mysqli_real_escape_string($conn, $_POST['rsidebarname']);
        $rsidebar       = mysqli_real_escape_string($conn, $_POST['rsidebar']);

        // necessary stuff
        $homePage       = mysqli_real_escape_string($conn, $_POST['homepage']);
        $url            = mysqli_real_escape_string($conn, $_POST['url']);


        // Add the data to the database
        $sql = "INSERT INTO page (pagename,
                                    content,
                                    lsidebarname,
                                    rsidebarname,
                                    lsidebar,
                                    rsidebar,
                                    home_page,
                                    url)
                VALUES ('$pagename',
                        '$content',
                        '$lsidebarname',
                        '$rsidebarname',
                        '$lsidebar',
                        '$rsidebar',
                        '$homePage',
                        '$url')
            ";

        if ($conn->query($sql) === TRUE) {
            //echo "DONE!!!";
            header('Location: ' . ADMIN_URL . '/edit-pages.php');
        }
        else {
            echo "Error: " . $sql . "<br><br>" . $conn->error;
        }
        mysqli_close($conn);
    }
    else {
        // Go back
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}