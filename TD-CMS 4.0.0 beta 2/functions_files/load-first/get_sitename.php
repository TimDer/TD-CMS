<?php

function get_sitename() {
    require BASE_DIR . "/db.php";

    $sql    = "SELECT * FROM settings";
    $query  = mysqli_query($conn,$sql);

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo $row['sidename'];
        }
    }
    else {
        echo "there was an error displaying the sidename";
    }
}