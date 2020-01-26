<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

?>
    <h4 class="h4-color-wit">all setings</h4>
    <br>
    <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=general">General</a></p>
    <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=pages">Pages</a></p>
    <?php if ($_SESSION['set_footer'] === 'yes') { ?>
        <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=footer">Footer</a></p>
    <?php } ?>
    <?php if ($_SESSION['set_css'] === 'yes') { ?>
        <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=custom-css">Custom css</a></p>
    <?php } ?>
    <?php if ($_SESSION['add_or_edit_users'] === 'yes') { ?>
        <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=users">Users</a></p>
    <?php } ?>
<?php

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>