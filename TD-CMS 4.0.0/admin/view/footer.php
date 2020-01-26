<?php 

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {
?>
</body>
</html>
<?php } else { header('Location: ' . ADMIN_URL . '/login.php'); } ?>