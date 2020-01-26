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

        <form action="<?php echo ADMIN_URL; ?>/setings/footer-update.php" method="POST">
            <input type="submit" value="save"><br><br>
            <p>&ltfooter class="<input style="width: 60%" type="text" name="footer-class" value="<?php echo $row['footerclass']; ?>">"&gt</p>
                <textarea type="text" name="footer" class="textarea-size"><?php echo $row['footer']; ?></textarea>
            <p>&lt/footer&gt</p>
        </form>

<?php

    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>