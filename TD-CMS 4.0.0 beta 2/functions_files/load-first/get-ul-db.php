<?php

// Include the <ul> tags in the header

function get_ul_database($ulClass = "", $liClass = "", $aClass = "") {
    //connect to the database
    require BASE_DIR . "/db.php";
        
    //query the data from the database
    $SelectPageTabel = "SELECT * FROM page ORDER BY theorder";
    $result = mysqli_query($conn,$SelectPageTabel);
    
    //this will put the data from the database in a array and from there display it to the user
    if ($result) {
        echo '<ul class="' . $ulClass . '">';
            
        while($row = mysqli_fetch_assoc($result)) {
            echo "<li class=\"" . $liClass . "\"><a class=\"" . $aClass . "\" href=\"" . BASE_URL . "/" . $row["url"] . "\">" . $row["pagename"] . "</a></li>";
        }
            
        echo '</ul>';
    }
    // if there is no data in the database
    else {
        echo "<p>No pages found</p>";
    }
    $conn->close();
}

// /Include the <ul> tags in the header