<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {
    ?>
    <h4 class="h4-color-wit">all settings</h4>
    <br>
    <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=general">General</a></p>
    <?php 
    
    if ($rowPermission['set_home_page'] === 'yes' OR $rowPermission['deletepages'] === 'yes' OR $rowPermission['set_theorder'] === 'yes' OR $rowPermission['edit_posts'] === 'yes' OR $rowPermission['delete_post'] === 'yes') { 
        ?>
            <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=pages">Pages - Posts</a></p>
        <?php
    }
    if ($rowPermission['set_footer'] === 'yes') {
        ?>
            <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=footer">Footer</a></p>
        <?php
    }
    if ($rowPermission['set_css'] === 'yes') {
        ?>
            <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=custom-css">Custom css</a></p>
        <?php
    }
    if ($rowPermission['set_template'] === 'yes') {
        ?>
            <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=templates">Templates</a></p>
        <?php
    }
    if ($rowPermission['add_or_edit_users'] === 'yes') {
        ?>
            <p><a href="<?php echo ADMIN_URL; ?>/setings.php?command=users">Users</a></p>
        <?php
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>