<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

?>

    <div class="col-sm-12">
        <h2>Add a new user</h2>
        <form action="<?php echo ADMIN_URL; ?>/setings/users-submit.php?adduser=1" method="POST">
            <div class="col-sm-4">
                username: <p><input type="text" name="username"></p>
            </div>
            <div class="col-sm-8">
                password: <p><input type="password" name="password"></p>
            </div>
            <input type="submit" value="Add">
        </form>
    </div>

    <br class="br-15">
    <div class="col-sm-12">
        <h2>Edit users / delete users</h2>
        <p class="col-sm-1">Id</p>
        <p class="col-sm-2">Username</p>
        <p class="col-sm-3">Edit user</p>
        <p class="col-sm-6">Delete user</p>
    </div>
    <br class="br-10">
    <?php

    require_once BASE_DIR . '/db.php';
    $sqlUsers   = "SELECT * FROM users";
    $sqlQuery   = mysqli_query($conn, $sqlUsers);

    while ($row = mysqli_fetch_assoc($sqlQuery)) {
        ?>

        <div class="col-sm-12">
            <p class="col-sm-1"><?php echo $row['id']; ?></p>
            <p class="col-sm-2"><?php echo $row['user']; ?></p>
            <p class="col-sm-3">edit: <a href="<?php echo ADMIN_URL; ?>/setings.php?command=users&edit=<?php echo $row['id']; ?>"><?php echo $row['user']; ?></a></p>
            <p class="col-sm-6">delete:
                <?php

                    if ($row['delete_this_user'] === 'yes') {
                        echo '<a href="' . ADMIN_URL . '/setings/users-submit.php?deluser=' . $row['id'] . '">' . $row['user'] . '</a>';
                    }
                    else {
                        echo 'You have no permission to delete this user';
                    }
                    
                ?>
            </p>
        </div>

        <?php
    }

    ?>

<?php

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>