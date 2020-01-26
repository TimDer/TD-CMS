<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {
    if ($rowPermission['edit_posts'] === 'yes') {
        echo '<h4  class="h4-color-wit">List of all posts</h4>';
        
        require_once BASE_DIR . '/db.php';

        $selectLinkData = "SELECT * FROM posts";
        $query = mysqli_query($conn,$selectLinkData);

        if ($query->num_rows > 0) {
            while ($link = mysqli_fetch_assoc($query)) {
                echo '<p><a href="'. ADMIN_URL . '/edit-posts.php?edit=' . $link['id'] . '">' . $link['post_name'] .'</a></p>';
            }
        }
        else {
            echo '<br><p class="h4-color-wit">No pages found</p>';
        }
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}