<?php

// small functions

    function get_tem_header() {
        include TEMP_DIR . "/header.php";
    }
    function get_tem_content() {
        include TEMP_DIR . "/content.php";
    }
    function get_tem_footer() {
        include TEMP_DIR . "/footer.php";
    }


// big code functions

    $filesFirst = glob("./functions_files/load-first/*.php");

    foreach ($filesFirst as $fileFirst) {
        require "$fileFirst";
    }

    $filesSecond = glob("./functions_files/load-second/*.php");

    foreach ($filesSecond as $fileSecond) {
        require "$fileSecond";
    }
