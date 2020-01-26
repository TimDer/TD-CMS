<?php

function get_min_head() {
    require BASE_DIR . "/db.php";

    $sql    = "SELECT * FROM settings";
    $query  = mysqli_query($conn,$sql);

    // META info
    echo "<meta charset=\"utf-8\">";
    echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";

    // SEO
    if (isset($_GET['page'])) {
        if (isset($_GET['cat'])) {
            $cat            = mysqli_real_escape_string($conn, $_GET['cat']);
            $catSql         = "SELECT * FROM posts WHERE url='$cat'";
            $catSqlQuery    = mysqli_query($conn, $catSql);

            if ($catSqlQuery->num_rows > 0) {
                if ($catRow = mysqli_fetch_assoc($catSqlQuery)) {
                    echo '<meta name="author" content="' . $catRow['author'] . '">';
                    echo '<meta name="keywords" content="' . $catRow['keywords'] . '">';
                    echo '<meta name="description" content="' . $catRow['description'] . '">';
                }
            }
        }
        else {
            $page           = mysqli_real_escape_string($conn, $_GET['page']);
            $pageSql        = "SELECT * FROM page WHERE url='$page'";
            $pageSqlQuery   = mysqli_query($conn, $pageSql);

            if ($pageSqlQuery->num_rows > 0) {
                if ($pageRow = mysqli_fetch_assoc($pageSqlQuery)) {
                    echo '<meta name="author" content="' . $pageRow['author'] . '">';
                    echo '<meta name="keywords" content="' . $pageRow['keywords'] . '">';
                    echo '<meta name="description" content="' . $pageRow['description'] . '">';
                }
            }
        }
    }
    else {
        $homeSql        = "SELECT * FROM page WHERE home_page='yes'";
        $homeSqlQuery   = mysqli_query($conn, $homeSql);

        if ($homeSqlQuery->num_rows > 0) {
            if ($homeRow = mysqli_fetch_assoc($homeSqlQuery)) {
                echo '<meta name="author" content="' . $homeRow['author'] . '">';
                echo '<meta name="keywords" content="' . $homeRow['keywords'] . '">';
                echo '<meta name="description" content="' . $homeRow['description'] . '">';
            }
        }
    }
    
    // CSS link
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . TEMP_URL . "/styles.css\">";

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<title>" . $row['sidename'] . "</title>" . PHP_EOL;
        }
    }
    else {
        echo "there was an error displaying the sidename";
    }
}