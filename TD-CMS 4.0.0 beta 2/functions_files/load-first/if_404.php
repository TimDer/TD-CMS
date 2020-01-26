<?php

function if_404() {
    require BASE_DIR . '/db.php';
    if (isset($_GET['page'])) {
        $urlPage    = mysqli_real_escape_string($conn, $_GET['page']);
        
        $sql        = "SELECT * FROM page WHERE url='$urlPage'";
        $sqlquery   = mysqli_query($conn, $sql);

        if ($sqlquery->num_rows > 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    elseif (isset($_GET['s'])) {
        $searchResult           = mysqli_real_escape_string($conn, $_GET['s']);
        
        $searchResultSqlpage    = "SELECT * FROM page WHERE pagename LIKE '%$searchResult%' OR
                                                            content LIKE '%$searchResult%' OR
                                                            lsidebarname LIKE '%$searchResult%' OR
                                                            rsidebarname LIKE '%$searchResult%' OR
                                                            lsidebar LIKE '%$searchResult%' OR
                                                            rsidebar LIKE '%$searchResult%' OR
                                                            home_page LIKE '%$searchResult%' OR
                                                            url LIKE '%$searchResult%'";
        $searchResultQueryPage  = mysqli_query($conn, $searchResultSqlpage);

        if ($searchResultQueryPage->num_rows > 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
}