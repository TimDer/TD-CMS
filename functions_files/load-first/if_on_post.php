<?php

function if_on_post() {
    if (isset($_GET['cat'])) {
        require BASE_DIR . '/db.php';
        $url        = mysqli_real_escape_string($conn, $_GET['cat']);
        $sqlPost    = "SELECT * FROM posts WHERE url='$url'";
        $querePosts = mysqli_query($conn, $sqlPost);

        if ($querePosts->num_rows > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    else {
        return FALSE;
    }
}