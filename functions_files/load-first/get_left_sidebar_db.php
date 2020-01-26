<?php

// Include the left sidebar

function get_left_sidebar_database() {
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
            if ($row['lsidebarname'] !== '' OR $row['lsidebar'] !== '') {
                echo "<h1>" . $row['lsidebarname'] . "</h1>";
                echo "<p>" . $row['lsidebar'] . "</p>";
            }
            else {
                if (file_exists(TEMP_DIR . '/sidebar_left.php')) {
                    require TEMP_DIR . '/sidebar_left.php';
                }
                else {
                    echo '<h1>No results</h1>';
                }
            }
        }
    }
    else {
        //connect to the database
        require BASE_DIR . "/db.php";

        //get the url with the escape sql injection function
        $url = "yes";

        //query the data from the database
        $SelectPageTabel = "SELECT *
                            FROM page
                            WHERE home_page = '$url' ";
        $result = mysqli_query($conn,$SelectPageTabel);
        while($row = mysqli_fetch_assoc($result)) {
            if ($row['lsidebarname'] !== '' OR $row['lsidebar'] !== '') {
                echo "<h1>" . $row['lsidebarname'] . "</h1>";
                echo "<p>" . $row['lsidebar'] . "</p>";
            }
            else {
                if (file_exists(TEMP_DIR . '/sidebar_left.php')) {
                    require TEMP_DIR . '/sidebar_left.php';
                }
                else {
                    echo '<h1>No results</h1>';
                }
            }
        }
    }
    $conn->close();
}

// /Include the left sidebar