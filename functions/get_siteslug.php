<?php

function get_siteslug() {
    require BASE_DIR . "/db.php";

    $sql    = "SELECT * FROM settings";
    $query  = mysqli_query($conn,$sql);

    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo $row['sideslug'];
        }
    }
    else {
        echo "there was an error displaying the sidename";
    }
}