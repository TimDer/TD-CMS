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
    ?>
    <div class="container-fluid text-center">    
      <div class="row content">
        <div class="col-sm-2 sidenav">
            <div class="space-in-content">
              <li><a href="<?php echo ADMIN_URL; ?>/edit-pages.php">Edit-pages</a></li>
              <li><a href="<?php echo ADMIN_URL; ?>/edit-posts.php">Edit-posts</a></li>
              <li><a href="<?php echo ADMIN_URL; ?>/media.php">Media</a></li>
              <li><a href="<?php echo ADMIN_URL; ?>/downloads.php">Downloads</a></li>
              <li><a href="<?php echo ADMIN_URL; ?>/setings.php">Setings</a></li>
            </div>
        </div>
        <div class="text-field col-sm-10 text-left space-in-content"> 
          <h1>Dashboard</h1>
          <p>Welcome to TD-CMS</p>
          <hr>
          <h3>All pages</h3>
          <hr>
          <?php admin_show_all_pages(); ?>
        </div>
      </div>
    </div>

    <?php
  }
  require ADMIN_DIR . "/view/footer.php";

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>