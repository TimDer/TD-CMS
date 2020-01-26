<?php


function get_search() {
    if (isset($_GET['s'])) {
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
}