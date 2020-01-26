<?php

// include template functions

    function get_tem_header() {
        include TEMP_DIR . "/header.php";
    }
    function get_tem_content() {
        include TEMP_DIR . "/content.php";
    }
    function get_tem_footer() {
        include TEMP_DIR . "/footer.php";
    }


// functions to Include data from the database

    require BASE_DIR . "/functions/get_min_head.php";
    require BASE_DIR . "/functions/get-ul-db.php";
    require BASE_DIR . "/functions/get_content_db.php";
    require BASE_DIR . "/functions/get_left_sidebar_db.php";
    require BASE_DIR . "/functions/get_right_sidebar_db.php";
    require BASE_DIR . "/functions/get_sitename.php";
    require BASE_DIR . "/functions/get_siteslug.php";
    require BASE_DIR . "/functions/get_db_footer.php";
    require BASE_DIR . "/functions/get_custom_css_db.php";