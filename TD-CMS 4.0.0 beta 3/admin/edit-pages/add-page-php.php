<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    require BASE_DIR . "/db.php";

    if (isset($_POST['pagename'])) {
        
        $randomUrl      = md5(date("ymd") . time() . mt_rand(0,100000));


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
        // SEO
        $author         = mysqli_real_escape_string($conn, $_POST['author']);
        $keywords       = mysqli_real_escape_string($conn, $_POST['keywords']);
        $description    = mysqli_real_escape_string($conn, $_POST['description']);
        


        // Adding the data into the database
        $sql = "INSERT INTO page (pagename,
                                    content,
                                    lsidebarname,
                                    rsidebarname,
                                    lsidebar,
                                    rsidebar,
                                    home_page,
                                    url,
                                    author,
                                    keywords,
                                    description,
                                    post_page,
                                    theorder)
                VALUES ('$pagename',
                        '$content',
                        '$lsidebarname',
                        '$rsidebarname',
                        '$lsidebar',
                        '$rsidebar',
                        '$homePage',
                        '$url',
                        '$author',
                        '$keywords',
                        '$description',
                        '$post_page',
                        '0')
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