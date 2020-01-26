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
                echo "<h1>" . $row['rsidebarname'] . "</h1>";
                echo "<p>" . $row['rsidebar'] . "</p>";
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
                echo "<h1>" . $row['rsidebarname'] . "</h1>";
                echo "<p>" . $row['rsidebar'] . "</p>";
            }
        }
        $conn->close();
    }

// /Include the right sidebar