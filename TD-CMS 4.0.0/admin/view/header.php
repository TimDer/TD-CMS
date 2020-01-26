<?php 

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

require ADMIN_DIR . "/functions.php";

if (isset($_SESSION['user'])) {
    require BASE_DIR . '/db.php';

    $idPermissionHeader = $_SESSION['id'];

    $sqlUserid      = "SELECT * FROM users WHERE id='$idPermissionHeader'";
    $queryUserid    = mysqli_query($conn, $sqlUserid);

    if ($queryUserid->num_rows > 0) {
        if ($rowPermissionHeader = mysqli_fetch_assoc($queryUserid)) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <title>TD-CMS Admin</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/bootstrap/css/bootstrap.min.css">
                <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/styles.css">
                <script src="<?php echo ADMIN_URL; ?>/bootstrap/js/jquery.min.js"></script>
                <script src="<?php echo BASE_URL; ?>/jquery-ui.min.js"></script>
                <script src="<?php echo ADMIN_URL; ?>/setings/js/menus.js.php"></script>
                <script src="<?php echo ADMIN_URL; ?>/bootstrap/js/bootstrap.min.js"></script>
                <script src='<?php echo ADMIN_URL; ?>/apis/tinymce/tinymce.min.js'></script>
                <script src='<?php echo ADMIN_URL; ?>/apis/tinymce/init-tinymce.js'></script>
            </head>
            <body>

            <header>
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>                        
                            </button>
                            <p class="navbar-brand">TD-CMS 4.0.0</p>
                            <!--<a class="navbar-brand" href="#">TD-CMS</a>-->
                        </div>
                        <div class="collapse navbar-collapse" id="myNavbar">
                            <ul class="nav navbar-nav li-color">
                                <li><a href="<?php echo ADMIN_URL; ?>/dashboard.php">Dashboard</a></li>
                                <?php
                                    if ($rowPermissionHeader['edit_pages'] === 'yes' OR $rowPermissionHeader['add_pages'] === 'yes') {
                                        ?>
                                        <li><a href="<?php echo ADMIN_URL; ?>/edit-pages.php">Pages</a></li>
                                        <?php
                                    }
                                ?>
                                <?php
                                    if ($rowPermissionHeader['add_posts'] === 'yes' OR $rowPermissionHeader['edit_posts'] === 'yes') {
                                        ?>
                                        <li><a href="<?php echo ADMIN_URL; ?>/edit-posts.php">Posts</a></li>
                                        <?php
                                    }
                                ?>
                                <?php
                                    if ($rowPermissionHeader['modify_media'] === 'yes') {
                                        ?>
                                        <li><a href="<?php echo ADMIN_URL; ?>/media.php">media</a></li>
                                        <?php
                                    }
                                ?>
                                <?php
                                    if ($rowPermissionHeader['modify_downloads'] === 'yes') {
                                        ?>
                                        <li><a href="<?php echo ADMIN_URL; ?>/downloads.php">Downloads</a></li>
                                        <?php
                                    }
                                ?>

                                <?php
                                    if ($rowPermissionHeader['deletepages'] === 'yes' OR $rowPermissionHeader['set_home_page'] === 'yes' OR $rowPermissionHeader['set_theorder'] === 'yes' OR $rowPermissionHeader['set_footer'] === 'yes' OR $rowPermissionHeader['set_css'] === 'yes' OR $rowPermissionHeader['edit_posts'] === 'yes' OR $rowPermissionHeader['delete_post'] === 'yes' OR $rowPermissionHeader['edit_general_settings'] === 'yes' OR $rowPermissionHeader['add_or_edit_users'] === 'yes') {
                                        ?>
                                        <li><a href="<?php echo ADMIN_URL; ?>/setings.php">Settings</a></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                            <div class="col-sm-1">
                                <form action="<?php echo ADMIN_URL; ?>/login.php" method="GET">
                                    <input class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="logout" value=" logout ">
                                </form>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?php echo BASE_URL; ?>" target="_blank"><span class="glyphicon glyphicon-log-in"></span> go to the home page</a></li>
                            </ul>
                        
                        </div>
                    </div>
                </nav>
            </header>
            <?php
        }
    }
} 
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}
?>