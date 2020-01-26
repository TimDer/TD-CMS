<?php

function get_min_head() {
        require BASE_DIR . "/db.php";

        $sql    = "SELECT * FROM settings";
        $query  = mysqli_query($conn,$sql);

        echo "
                <link rel=\"stylesheet\" href=\"" . BASE_URL . "/bootstrap/css/bootstrap.min.css\">
                <script src=\"" . BASE_URL . "/jquery.min.js\"></script>
                <script src=\"". BASE_URL ."/bootstrap/js/bootstrap.js\"></script>
                <link rel=\"stylesheet\" href=\"" . BASE_URL . "/template/styles.css\">
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