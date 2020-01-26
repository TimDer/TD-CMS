<?php

if (!isset($start)) {
    require_once '../start.php';
}

// Admin functions
if (isset($_SESSION['user'])) {
    function admin_show_all_pages() {
        require BASE_DIR . "/db.php";
        $SelectPageTabel = "SELECT * FROM page";
        $result = mysqli_query($conn,$SelectPageTabel);
        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<h1>" . $row['pagename'] . "</h1>";
                echo "<p>" . $row['content'] . "</p><hr>";
            }
        }
        else {
            echo "<p>No pages found</p>";
        }
    }

    function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
    
        if (!is_dir($dir)) {
            return unlink($dir);
        }
    
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
    
        }
    
        return rmdir($dir);
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}