<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    if (isset($_GET['error'])) {
        if ($_GET['error'] = 1) {
            echo '<div class="col-sm-1"></div>';
            echo '<div class="col-sm-11"><p style="color: #FF0000;">please fill out all fields</p></div>';
        }
    }
    elseif (isset($_GET['update'])) {
        if ($_GET['update'] = 1) {
            echo '<div class="col-sm-1"></div>';
            echo '<div class="col-sm-11"><p>update successfully</p></div>';
        }
    }

    require BASE_DIR . "/db.php";

    $sql = "SELECT * FROM settings";
    $query = mysqli_query($conn,$sql);

    while ($row = mysqli_fetch_assoc($query)) {
?>
        <form action="<?php echo ADMIN_URL; ?>/setings/general-update.php" method="POST">
            <div class="col-sm-1">

                <p>sitename:</p><br>
                <p>sideslug:</p>

            </div>
            <div class="col-sm-11">

                <input type="text" name="sidename" maxlength="40" value="<?php echo $row['sidename']; ?>"><br><br>
                <input type="text" name="sideslug" maxlength="100" value="<?php echo $row['sideslug']; ?>"><br><br>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="submit" value="save settings">

            </div>
        </form>
<?php

    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>