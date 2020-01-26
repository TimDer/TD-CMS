<?php

// Include the content

function get_content_database() {
    if (isset($_GET['page'])) {
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
        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<h1>" . $row['pagename'] . "</h1>";
                echo "<p>" . $row['content'] . "</p>";
            }
        }
        else {
            if (file_exists(TEMP_DIR . '/404.php')) {
                require TEMP_DIR . '/404.php';
            }
            else {
                echo '<h1>404</h1>';
            }
        }
    }
    elseif (isset($_GET['s'])) {
        //connect to the database
        require BASE_DIR . "/db.php";

        $url = mysqli_real_escape_string($conn, $_GET['s']);

        $SelectPageTabel = "SELECT *
                            FROM page
                            WHERE pagename LIKE '%$url%' OR content LIKE '%$url%'";
        $result = mysqli_query($conn,$SelectPageTabel);

        if ($result->num_rows > 0) {
            if (file_exists(TEMP_DIR . '/search-results.php')) {
                require TEMP_DIR . '/search-results.php';
                echo '<br>';
            }
            else {
                echo '<h1>search results:</h1><br>';
            }
            while($row = mysqli_fetch_assoc($result)) {
                echo '<a href="'.BASE_URL.'/'.$row['url'].'">'.$row['pagename'].'</a><br><br>';
            }
        }
        else {
            if (file_exists(TEMP_DIR . '/search404.php')) {
                require TEMP_DIR . '/search404.php';
            }
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