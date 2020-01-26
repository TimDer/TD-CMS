<?php

function if_homepage() {
    if (isset($_GET['page'])) {
        require BASE_DIR . '/db.php';

        $url                = mysqli_real_escape_string($conn, $_GET['page']);

        $sqlIfHomepage      = "SELECT * FROM page WHERE url='$url'";
        $queryIfHomepage    = mysqli_query($conn, $sqlIfHomepage);

        if ($queryIfHomepage->num_rows > 0) {
            while ($rowIfHomepage = mysqli_fetch_assoc($queryIfHomepage)) {
                if ($rowIfHomepage['home_page'] === 'yes') {
                    return TRUE;
                }
                else {
                    return FALSE;
                }
            }
        }
    }
    else {
        if (!isset($_GET['s'])) {
            return TRUE;
        }
    }
}