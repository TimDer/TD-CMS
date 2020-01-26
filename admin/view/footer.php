<?php 

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {
?>
<script src="<?php echo BASE_URL; ?>/bootstrap/js/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/bootstrap/js/bootstrap.min.js"></script>
<script src='<?php echo ADMIN_URL; ?>/apis/tinymce/tinymce.min.js'></script>
<script src='<?php echo ADMIN_URL; ?>/apis/tinymce/init-tinymce.js'></script>
</body>
</html>
<?php } else { header('Location: ' . ADMIN_URL . '/login.php'); } ?>