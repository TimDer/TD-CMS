<?php

function get_db_footer() {
    require BASE_DIR . '/db.php';

    $sql   = "SELECT * FROM settings";
    $query = mysqli_query($conn, $sql);


    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo '<footer class="' . $row['footerclass'] . '">';
            echo $row['footer'];
            echo '</footer>';
        }
    }
}