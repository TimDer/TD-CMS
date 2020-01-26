<?php

// Include the content

function get_content_database() {
    if (isset($_GET['page'])) {
        require BASE_DIR . "/db.php";

        $url = mysqli_real_escape_string($conn, $_GET['page']);

        $SelectPageTable = "SELECT *
                            FROM page
                            WHERE url = '$url' ";
        $result = mysqli_query($conn,$SelectPageTable);

        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                if ($row['post_page'] === '') {
                    echo "<h1>" . $row['pagename'] . "</h1>";
                    echo "<p>" . $row['content'] . "</p>";
                }
                if (!isset($postAllif)) {
                    $postAll            = $row['post_page'];
                    $sqlPostsAll        = "SELECT * FROM posts WHERE category='$postAll' ORDER BY date_added DESC";
                    $resultPostsAll     = mysqli_query($conn, $sqlPostsAll);
                    $postAllif          = 1;
                }
                if (!isset($postif) AND isset($_GET['cat'])) {
                    $post               = $_GET['page'];
                    $urlPost            = $_GET['cat'];
                    $sqlPosts           = "SELECT * FROM posts WHERE category='$post' AND url='$urlPost' ORDER BY date_added DESC";
                    $resultPosts        = mysqli_query($conn, $sqlPosts);
                    $postif             = 1;
                }
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
                        echo "<h1>" . $row['pagename'] . "</h1>";
                        echo "<p>" . $row['content'] . "</p>";
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
                            echo 'create a "/template/postall.php" file';
                        }
                    }
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
    elseif (isset($_GET['s'])) {
        //connect to the database
        require BASE_DIR . "/db.php";

        $url = mysqli_real_escape_string($conn, $_GET['s']);

        $SelectPageTable    = "SELECT *
                                FROM page
                                WHERE pagename LIKE '%$url%' OR content LIKE '%$url%'";
        $result             = mysqli_query($conn,$SelectPageTable);

        $selectPostTable    = "SELECT * FROM posts WHERE post_name LIKE '%$url%' OR post_1 LIKE '%$url%' OR post_2 LIKE '%$url%' OR post_3 LIKE '%$url%'";
        $resultPostsSearch  = mysqli_query($conn, $selectPostTable);

        if ($result->num_rows > 0 OR $resultPostsSearch->num_rows > 0) {
            if ($result->num_rows > 0) {
                if (file_exists(TEMP_DIR . '/search-results.php')) {
                    $search_results = 'page';
                    require TEMP_DIR . '/search-results.php';
                    echo '<br>';
                }
                else {
                    echo '<h1>page results:</h1><br>';
                }
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<a href="'.BASE_URL.'/'.$row['url'].'">'.$row['pagename'].'</a><br><br>';
                }
            }

            if ($resultPostsSearch->num_rows > 0) {
                if (file_exists(TEMP_DIR . '/search-results.php')) {
                    $search_results = 'post';
                    require TEMP_DIR . '/search-results.php';
                    echo '<br>';
                }
                else {
                    echo '<h1>post results:</h1><br>';
                }

                $sqlPageSearch      = "SELECT * FROM page";
                $resultPageSearch   = mysqli_query($conn, $sqlPageSearch);

                while ($rowPostsSearch = mysqli_fetch_assoc($resultPostsSearch)) {
                    if ($rowPostsSearch['category'] !== 'not published') {
                        echo '<a href="'.BASE_URL.'/'.$rowPostsSearch['category'].'/'.$rowPostsSearch['url'].'">'.$rowPostsSearch['post_name'].'</a><br><br>';
                    }
                }
            }
        }
        else {
            if (file_exists(TEMP_DIR . '/search404.php')) {
                require TEMP_DIR . '/search404.php';
            }
        }
        

    }
    else {
        //connect to the database
        require BASE_DIR . "/db.php";
        
        //get the home page
        $url = "yes";

        //query the data from the database
        $SelectPageTable = "SELECT *
                            FROM page
                            WHERE home_page = '$url' ";
        $result = mysqli_query($conn,$SelectPageTable);
        while($row = mysqli_fetch_assoc($result)) {
            echo "<h1>" . $row['pagename'] . "</h1>";
            echo "<p>" . $row['content'] . "</p>";
        }
    }
    $conn->close();
}