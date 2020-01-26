<?php

// Include the content

function get_content() {
    if (!empty($_GET['page'])) {
        require BASE_DIR . "/db.php";

        $url = mysqli_real_escape_string($conn, $_GET['page']);

        $SelectPageTable = "SELECT * FROM page WHERE url = '$url'";
        $result = mysqli_query($conn,$SelectPageTable);

        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo $row['content'];
            }
        }
    }
    else {
        //connect to the database
        require BASE_DIR . "/db.php";
        
        //get the home page
        $url = "yes";

        //query the data from the database
        $SelectPageTable = "SELECT * FROM page WHERE home_page = '$url'";
        $result = mysqli_query($conn,$SelectPageTable);

        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo $row['content'];
            }
        }
    }
}