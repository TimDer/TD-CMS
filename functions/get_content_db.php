<?php

// Include the content

function get_content_database() {
    if (!empty($_GET['page'])) {
        //connect to the database
        require BASE_DIR . "/db.php";
        
        //get the url with the escape sql injection function
        $url = mysqli_real_escape_string($conn, $_GET['page']);

        //query the data from the database
        $SelectPageTabel = "SELECT *
                            FROM page
                            WHERE url = '$url' ";
        $result = mysqli_query($conn,$SelectPageTabel);
        
        //display the data from the database from an array on the page to the user
        while($row = mysqli_fetch_assoc($result)) {
            echo "<h1>" . $row['pagename'] . "</h1>";
            echo "<p>" . $row['content'] . "</p>";
        }
    }
    else {
        //connect to the database
        require BASE_DIR . "/db.php";
        
        //get the home page
        $url = "yes";

        //query the data from the database
        $SelectPageTabel = "SELECT *
                            FROM page
                            WHERE home_page = '$url' ";
        $result = mysqli_query($conn,$SelectPageTabel);
        while($row = mysqli_fetch_assoc($result)) {
            echo "<h1>" . $row['pagename'] . "</h1>";
            echo "<p>" . $row['content'] . "</p>";
        }
    }
    $conn->close();
}

// /Include the content