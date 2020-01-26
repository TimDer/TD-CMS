<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    require BASE_DIR . "/db.php";

    if (isset($_POST['content']) AND isset($_POST['pagename'])) {
        // content
        $content        = $_POST['content'];
        $pagename       = $_POST['pagename'];

        // left sideber
        $lsidebarname   = $_POST['lsidebarname'];
        $lsidebar       = $_POST['lsidebar'];

        // right sidebar
        $rsidebarname   = $_POST['rsidebarname'];
        $rsidebar       = $_POST['rsidebar'];

        // necessary stuff
        $homePage       = $_POST['homepage'];
        $url            = $_POST['url'];


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