<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    if (isset($_GET['update'])) {
        echo '<p>update successfully</p>';
    }
    elseif (isset($_GET['error'])) {
        echo '<p>something went wrong</p>';
    }

    require_once BASE_DIR . '/db.php';

    $sql   = "SELECT * FROM settings";
    $query = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
?>

        <form action="<?php echo ADMIN_URL; ?>/setings/custom-css-update.php" method="POST">
            <input type="submit" value="save"><br><br>
            <p>&ltstyle&gt</p>
                <textarea type="text" name="custom-css" class="textarea-size"><?php echo $row['customcss']; ?></textarea>
            <p>&lt/style&gt</p>
        </form>

<?php

    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>