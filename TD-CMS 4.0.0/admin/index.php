<?php 

if (!isset($start)) {
    require_once '../start.php';
}

session_start();

if (isset($_SESSION['user'])) {

  if ($_SESSION['time'] < time() - (60 * 15)) {
    header('Location: ' . ADMIN_URL . '/login.php?logout=logout');
  }
  else {
    $_SESSION['time'] = time();
    header('Location: ' . ADMIN_URL . '/dashboard.php');
  }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>