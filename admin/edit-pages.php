<?php 

if (!isset($start)) {
    require_once '../start.php';
}
require BASE_DIR . "/db.php";

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
            <div class="space-in-content sidebar-admin-panel">
                <h4><a href="<?php echo ADMIN_URL; ?>/edit-pages.php">Add a page</a></h4>
                <h4 class="h4-color-wit">List of all pages</h4>
                <?php require ADMIN_DIR . '/edit-pages/get-url.php'; ?>
            </div>
        </div>
        <div class="div-full col-sm-10 text-field">
          <div class="text-field text-left space-in-content2"> 
            <?php 
            
              if (isset($_GET['edit'])) {
                require ADMIN_DIR . "/edit-pages/edit-page-form.php";
              } 
              else {
                require ADMIN_DIR . "/edit-pages/add-page-form.php";
              }

            ?>

          </div>
        </div>
      </div>
    </div>

    <?php
    require ADMIN_DIR . "/view/footer.php";
  }
}
else {
  header('Location: ' . ADMIN_URL . '/login.php');
}

?>
