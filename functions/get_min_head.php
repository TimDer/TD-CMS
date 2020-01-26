<?php

function get_min_head() {
        require_once BASE_DIR . "/db.php";

        $sql    = "SELECT * FROM settings";
        $query  = mysqli_query($conn,$sql);

        echo "
                <link rel=\"stylesheet\" href=\"bootstrap/css/bootstrap.min.css\">
                <script src=\"./bootstrap/js/jquery.min.js\"></script>
                <script src=\"./bootstrap/js/bootstrap.min.js\"></script>
                <link rel=\"stylesheet\" href=\"./template/styles.css\">
                <meta charset=\"utf-8\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
            ";

        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<title>" . $row['sidename'] . "</title>";
            }
        }
        else {
            echo "there was an error displaying the sidename";
        }
    }