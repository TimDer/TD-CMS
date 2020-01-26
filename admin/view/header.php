<?php 

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

require ADMIN_DIR . "/functions.php";

if (isset($_SESSION['user'])) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <title>TD-CMS Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/styles.css">
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
                    <p class="navbar-brand">TD-CMS</p>
                    <!--<a class="navbar-brand" href="#">TD-CMS</a>-->
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav li-color">
                        <li><a href="<?php echo ADMIN_URL; ?>/index.php">Dashboard</a></li>
                        <li><a href="<?php echo ADMIN_URL; ?>/edit-pages.php">Edit-pages</a></li>
                        <li><a href="<?php echo ADMIN_URL; ?>/setings.php">Settings</a></li>
                        <li><a href="<?php echo ADMIN_URL; ?>/phpinfo.php">phpinfo();</a></li>
                    </ul>
                    <div class="col-sm-1">
                        <form action="<?php echo ADMIN_URL; ?>/login.php" method="GET">
                            <input class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="logout" value=" logout ">
                        </form>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo BASE_URL; ?>"><span class="glyphicon glyphicon-log-in"></span> go to the home page</a></li>
                    </ul>
                
                </div>
            </div>
        </nav>
    </header>

    <?php 
} 
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}
?>