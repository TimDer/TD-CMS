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
    $postid         = mysqli_real_escape_string($conn, $_POST['id']);
    if (empty($_POST['url'])) {
        $url        = $randomUrl;
    }
    else {
        $url        = mysqli_real_escape_string($conn, $_POST['url']);
    }
    $edited         = date("ymd") . time();

    // SEO (author, keywords, description)
    $author         = mysqli_real_escape_string($conn, $_POST['author']);
    $keywords       = mysqli_real_escape_string($conn, $_POST['keywords']);
    $description    = mysqli_real_escape_string($conn, $_POST['description']);

    // sql
    $sqlpost        = "UPDATE posts SET category='$category',
                                        post_name='$post_name',
                                        post_1='$POST_lable_1',
                                        post_2='$POST_lable_2',
                                        post_3='$POST_lable_3',
                                        author='$author',
                                        keywords='$keywords',
                                        description='$description',
                                        url='$url',
                                        date_edited='$edited'
                                        WHERE id='$postid'";

    if ($conn->query($sqlpost) === TRUE) {
        header('Location: ' . ADMIN_URL . '/edit-posts.php?edit=' . $postid);
    }
    else {
        echo 'not done: ' . $conn->error;
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}