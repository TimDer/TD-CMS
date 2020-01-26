<?php

function get_posts() {
    if (isset($_GET['page'])) {
        require BASE_DIR . "/db.php";

        //post all
        if (isset($_GET['cat'])) {
            $post               = mysqli_real_escape_string($conn, $_GET['page']);
            $urlPost            = mysqli_real_escape_string($conn, $_GET['cat']);
            $sqlPosts           = "SELECT * FROM posts WHERE category='$post' AND url='$urlPost' ORDER BY date_added DESC";
            $resultPosts        = mysqli_query($conn, $sqlPosts);
        }
        else {
            $postAll            = mysqli_real_escape_string($conn, $_GET['page']);
            $sqlPostsAll        = "SELECT * FROM posts WHERE category='$postAll' ORDER BY date_added DESC";
            $resultPostsAll     = mysqli_query($conn, $sqlPostsAll);
        }
        

        //regular Post


        $url = mysqli_real_escape_string($conn, $_GET['page']);

        $SelectPage = "SELECT * FROM page WHERE url = '$url' ";
        $result = mysqli_query($conn,$SelectPage);

        //run
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['post_page'] !== '') {
                    if (!empty($_GET['cat'])) {
                        if (file_exists(TEMP_DIR . '/post.php')) {
                            if ($resultPosts->num_rows > 0) {
                                if ($rowPosts = mysqli_fetch_assoc($resultPosts)) {
                                    if ($rowPosts['category'] !== 'not published') {
                                        require TEMP_DIR . '/post.php';
                                    }
                                }
                            }
                            else {
                                if (file_exists(TEMP_DIR . '/404.php')) {
                                    require TEMP_DIR . '/404.php';
                                }
                                else {
                                    echo '<h1>404</h1>';
                                }
                            }
                        }
                        else {
                            echo 'create a "/template/post.php" file';
                        }
                    }
                    else {
                        if (file_exists(TEMP_DIR . '/postsall.php')) {
                            if ($resultPostsAll->num_rows > 0) {
                                while ($rowPostsAll = mysqli_fetch_assoc($resultPostsAll)) {
                                    if ($rowPostsAll['category'] !== 'not published') {
                                        require TEMP_DIR . '/postsall.php';
                                    }
                                }
                            }
                        }
                        else {
                            echo 'create a "/template/postsall.php" file';
                        }
                    }
                }
            }
        }
    }
}