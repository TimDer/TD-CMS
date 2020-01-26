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


// Include the <ul> tags in the header (real)

function loop_array($menusArray = array(), $parent_id = 0, $ulClass = "", $liClass = "", $aClass = "") {
    if (!empty($menusArray[$parent_id])) {
        echo "<ul";
        if (!empty($ulClass)) {
            echo ' class="' . $ulClass . '"';
        }
        echo ">" . PHP_EOL;
        foreach ($menusArray[$parent_id] as $items) {
            echo "<li";
            if (!empty($liClass)) {
                echo ' class="' . $liClass . '"';
            }
            echo ">" . PHP_EOL;

            /* The link */
            if (substr($items["the_url"], 0,1) === "#") {
                echo '<a href="' . $items["the_url"] . '"';
                if (!empty($aClass)) {
                    echo ' class="' . $aClass . '"';
                }
                echo '>' . PHP_EOL;
                echo $items["the_name"] . PHP_EOL;
                echo "</a>" . PHP_EOL;
            }
            elseif (empty($items["the_url"])) {
                echo '<a href="#"';
                if (!empty($aClass)) {
                    echo ' class="' . $aClass . '"';
                }
                echo '>' . PHP_EOL;
                echo $items["the_name"] . PHP_EOL;
                echo "</a>" . PHP_EOL;
            }
            else {
                echo '<a href="' . BASE_URL . '/' . $items["the_url"] . '"';
                if (!empty($aClass)) {
                    echo ' class="' . $aClass . '"';
                }
                echo '>' . PHP_EOL;
                echo $items["the_name"] . PHP_EOL;
                echo "</a>" . PHP_EOL;
            }
            /* /The link */
            
            loop_array($menusArray, $items["id"], $ulClass, $liClass, $aClass);
            echo "</li>" . PHP_EOL;
        }
        echo "</ul>" . PHP_EOL;
    }
}

function get_real_ul_database($uuid = "", $ulClass = "", $liClass = "", $aClass = "") {
    if (empty($uuid)) {
        die("Please select a menu!");
    }

    require BASE_DIR . "/db.php";

    $SelectPageTabel    = "SELECT * FROM menus WHERE menu_name='$uuid' ORDER BY the_order";
    $result             = mysqli_query($conn,$SelectPageTabel);

    $menusArray = array();
    
    if ($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $menusArray[$row["parent_id"]][] = $row;
        }

        loop_array($menusArray, 0, $ulClass, $liClass, $aClass);
    }
    else {
        echo "<p>No pages found</p>";
    }
    $conn->close();
}

// /Include the <ul> tags in the header (real)