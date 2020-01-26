<?php 

if (!isset($start)) {
    require_once '../start.php';
}

require ADMIN_DIR . "/view/header.php"; 

if (isset($_SESSION['user'])) {

    if ($_SESSION['time'] < time() - (60 * 15)) {
        header('Location: ' . ADMIN_URL . '/login.php?logout=logout');
    }
    else {
        $_SESSION['time'] = time();
        
        require BASE_DIR . '/db.php';

        $idPermission = $_SESSION['id'];

        $sqlUserid      = "SELECT * FROM users WHERE id='$idPermission'";
        $queryUserid    = mysqli_query($conn, $sqlUserid);

        if ($queryUserid->num_rows > 0) {
            if ($rowPermission = mysqli_fetch_assoc($queryUserid)) {
                if ($rowPermission['add_posts'] === 'yes' OR $rowPermission['edit_posts'] === 'yes') {
                    ?>
                    <div class="container-fluid text-center">    
                    <div class="row content">
                        <div class="col-sm-2 sidenav">
                            <div class="space-in-content">
                                <?php
                                    if ($rowPermission['add_posts'] === 'yes') {
                                        ?>
                                        <h4><a href="<?php echo ADMIN_URL; ?>/edit-posts.php">Add a post</a></h4>
                                        <?php
                                    }
                                ?>
                                <?php require ADMIN_DIR . '/edit-posts/get-links.php'; ?>
                            </div>
                        </div>
                        <div class="text-field col-sm-10 text-left space-in-content div-full"> 
                            <h1>
                                <?php
                                    if (isset($_GET['edit'])) {
                                        if ($rowPermission['edit_posts'] === 'yes') {
                                            echo 'Edit post';
                                        }
                                        else {
                                            echo 'Add post';
                                        }
                                    }
                                    else {
                                        if ($rowPermission['add_posts'] === 'yes') {
                                            echo 'Add post';
                                        }
                                    }
                                ?>
                            </h1>
                            <hr>
                            <?php

                                if (isset($_GET['edit'])) {
                                    if ($rowPermission['edit_posts'] === 'yes') {
                                        require ADMIN_DIR . '/edit-posts/edit-posts-form.php';
                                    }
                                    else {
                                        require ADMIN_DIR . '/edit-posts/add-posts-form.php';
                                    }
                                }
                                else {
                                    if ($rowPermission['add_posts'] === 'yes') {
                                        require ADMIN_DIR . '/edit-posts/add-posts-form.php';
                                    }
                                }

                            ?>
                        </div>
                    </div>
                    </div>
                    <?php
                }
                else {
                    header('Location: ' . ADMIN_URL);
                }
            }
        }
    }
    require ADMIN_DIR . "/view/footer.php";

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>