<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    $edit = $_GET['edit'];

    require_once BASE_DIR . '/db.php';
    $sqlUserEdit    = "SELECT * FROM users WHERE id='$edit'";
    $queryUserEdit  = mysqli_query($conn, $sqlUserEdit);
    
    if ($row = mysqli_fetch_assoc($queryUserEdit)) {
        ?>

            <form action="<?php echo ADMIN_URL; ?>/setings/users-submit.php?edituser=update" method="POST">
                <div class="col-sm-12">
                    <p class="col-sm-2">username:</p>
                    <p class="col-sm-10"><input type="text" name="username" value="<?php echo $row['user']; ?>"></p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <p class="col-sm-2">password:</p>
                    <p class="col-sm-10"><input type="password" name="password"></p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <p class="col-sm-2">delete pages:</p>
                    <p class="col-sm-10">
                        <input type="radio" name="delpages" value="yes" <?php if ($row['deletepages'] === 'yes') { echo 'checked'; } ?>> yes
                        <input type="radio" name="delpages" value="no" <?php if ($row['deletepages'] === 'no') { echo 'checked'; } ?>> no
                    </p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <p class="col-sm-2">set a home page:</p>
                    <p class="col-sm-10">
                        <input type="radio" name="set_home_page" value="yes" <?php if ($row['set_home_page'] === 'yes') { echo 'checked'; } ?>> yes
                        <input type="radio" name="set_home_page" value="no" <?php if ($row['set_home_page'] === 'no') { echo 'checked'; } ?>> no
                    </p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <p class="col-sm-2">set order:</p>
                    <p class="col-sm-10">
                        <input type="radio" name="set_theorder" value="yes" <?php if ($row['set_theorder'] === 'yes') { echo 'checked'; } ?>> yes
                        <input type="radio" name="set_theorder" value="no" <?php if ($row['set_theorder'] === 'no') { echo 'checked'; } ?>> no
                    </p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <p class="col-sm-2">set footer:</p>
                    <p class="col-sm-10">
                        <input type="radio" name="set_footer" value="yes" <?php if ($row['set_footer'] === 'yes') { echo 'checked'; } ?>> yes
                        <input type="radio" name="set_footer" value="no" <?php if ($row['set_footer'] === 'no') { echo 'checked'; } ?>> no
                    </p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <p class="col-sm-2">set css:</p>
                    <p class="col-sm-10">
                        <input type="radio" name="set_css" value="yes" <?php if ($row['set_css'] === 'yes') { echo 'checked'; } ?>> yes
                        <input type="radio" name="set_css" value="no" <?php if ($row['set_css'] === 'no') { echo 'checked'; } ?>> no
                    </p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <p class="col-sm-2">add or edit users:</p>
                    <p class="col-sm-10">
                        <input type="radio" name="add_or_edit_users" value="yes" <?php if ($row['add_or_edit_users'] === 'yes') { echo 'checked'; } ?>> yes
                        <input type="radio" name="add_or_edit_users" value="no" <?php if ($row['add_or_edit_users'] === 'no') { echo 'checked'; } ?>> no
                    </p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <p class="col-sm-2">delete_this_user:</p>
                    <p class="col-sm-10">
                        <input type="radio" name="delete_this_user" value="yes" <?php if ($row['delete_this_user'] === 'yes') { echo 'checked'; } ?>> yes
                        <input type="radio" name="delete_this_user" value="no" <?php if ($row['delete_this_user'] === 'no') { echo 'checked'; } ?>> no
                    </p>
                </div>
                <br class="br-6">
                <div class="col-sm-12">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <input type="submit" value="save">
                    </div>
                </div>
                <input type="hidden" name="userid" value="<?php echo $row['id']; ?>">
            </form>

        <?php
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

/*

<form method="POST">
    <div class="col-sm-12">
        <p>username:</p>
        <p>password:</p>
        <p>delete pages:</p>
        <p>set a home page:</p>
        <p>set order:</p>
        <p>set footer:</p>
        <p>set css:</p>
        <p>add or edit users:</p>
    </div>
    <div class="col-sm-10">
        <p><input type="text" name="username" value="<?php echo $row['user']; ?>"></p>
    </div>
    <input type="hidden" name="userid" value="<?php echo $row['id']; ?>">
</form>

*/