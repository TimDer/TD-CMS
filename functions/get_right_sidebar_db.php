<?php

// Include the right sidebar

function get_right_sidebar_database() {
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
            

            while($row = mysqli_fetch_assoc($result)) {
                if ($row['rsidebarname'] !== '' AND $row['rsidebar'] !== '') {
                    echo "<h1>" . $row['rsidebarname'] . "</h1>";
                    echo "<p>" . $row['rsidebar'] . "</p>";
                }
                else {
                    if (file_exists(TEMP_DIR . '/sidebar_right.php')) {
                        require TEMP_DIR . '/sidebar_right.php';
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
                if ($row['rsidebarname'] !== '' AND $row['rsidebar'] !== '') {
                    echo "<h1>" . $row['rsidebarname'] . "</h1>";
                    echo "<p>" . $row['rsidebar'] . "</p>";
                }
                else {
                    if (file_exists(TEMP_DIR . '/sidebar_right.php')) {
                        require TEMP_DIR . '/sidebar_right.php';
                    }
                    else {
                        echo '<h1>No results</h1>';
                    }
                }
            }
        }
        $conn->close();
    }

// /Include the right sidebar