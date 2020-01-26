<?php 

if (!isset($start)) {
    require_once '../start.php';
}
//require_once "../db.php";

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
        <div class="text-field col-sm-12 text-left space-in-content"> 
          <?php phpinfo(); ?>
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