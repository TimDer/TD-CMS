<?php

function get_custom_css_db() {
    require BASE_DIR . '/db.php';

    $sql = "SELECT * FROM settings";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo '<style>';
            echo $row['customcss'];
            echo '</style>';
        }
    }
}