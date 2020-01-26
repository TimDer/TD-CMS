<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

	require BASE_DIR . '/db.php';

    $randomUrl      = md5(date("ymd") . time() . mt_rand(0,100000));

    $category       = mysqli_real_escape_string($conn, $_POST['category']);
    $post_name      = mysqli_real_escape_string($conn, $_POST['post_name']);
    $POST_lable_1   = mysqli_real_escape_string($conn, $_POST['POST_lable_1']);
    $POST_lable_2   = mysqli_real_escape_string($conn, $_POST['POST_lable_2']);
    $POST_lable_3   = mysqli_real_escape_string($conn, $_POST['POST_lable_3']);
    $Added          = date("ymd") . time();
    if (empty($_POST['url'])) {
        $url        = $randomUrl;
    }
    else {
        $url        = mysqli_real_escape_string($conn, $_POST['url']);
    }

    // SEO (author, keywords, description)
    $author         = mysqli_real_escape_string($conn, $_POST['author']);
    $keywords       = mysqli_real_escape_string($conn, $_POST['keywords']);
    $description    = mysqli_real_escape_string($conn, $_POST['description']);

    $sqlpost        = "INSERT INTO posts (category,
                                            post_name,
                                            post_1,
                                            post_2,
                                            post_3,
                                            author,
                                            keywords,
                                            description,
                                            url,
                                            date_added,
                                            date_edited)
                                    VALUES ('$category',
                                            '$post_name',
                                            '$POST_lable_1',
                                            '$POST_lable_2',
                                            '$POST_lable_3',
                                            '$author',
                                            '$keywords',
                                            '$description',
                                            '$url',
                                            '$Added',
                                            '')";

    if ($conn->query($sqlpost) === TRUE) {
        header('Location: ' . ADMIN_URL . '/edit-posts.php');
    }
    else {
        echo 'not done: ' . $conn->error;
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}