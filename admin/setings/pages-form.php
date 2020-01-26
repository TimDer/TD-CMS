<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

?>
    <div>
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="col-sm-1"><p>ID:</p></div>
                <div class="col-sm-2"><p>pagename:</p></div>
                <div class="col-sm-2"><p>Home_page:</p></div>
                <div class="col-sm-3"><p>Delete:</p></div>
                <div class="col-sm-4"><p>Order:</p></div>
            </div>
        </div>
        <form action="<?php echo ADMIN_URL; ?>/setings/pages-submit.php" method="POST">
            <div class="col-sm-12">
                <?php
                    require BASE_DIR . '/db.php';

                    $sql    = "SELECT * FROM page ORDER BY theorder";
                    $query  = mysqli_query($conn,$sql);

                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) { 
                ?>
                            <div class="col-sm-12">
                                <div class="col-sm-1">
                                    <p><?php echo $row['id']; ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <p><?php echo $row['pagename']; ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <?php if ($_SESSION['set_home_page'] === 'yes') { ?>
                                        <p>
                                            Yes: <input type="radio" name="homepage[<?php echo $row['id']; ?>]" value="yes" <?php if ($row['home_page']=="yes") { echo "checked"; } ?>>
                                            No: <input type="radio" name="homepage[<?php echo $row['id']; ?>]" value="no" <?php if ($row['home_page']=="no") { echo "checked"; } ?>>
                                        </p>
                                    <?php } else { ?>
                                        <p>you have no permission</p>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-3">
                                    <?php if ($_SESSION['deletepages'] === 'yes') { ?>
                                        <a href="<?php echo ADMIN_URL; ?>/setings/pages-delete.php?del-page=<?php echo $row['id']; ?>">delete: <?php echo $row['pagename']; ?></a>
                                    <?php } else { ?>
                                        <p>you have no permission</p>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php if ($_SESSION['set_theorder'] === 'yes') { ?>
                                        <p><input class="setings-pages-order" type="text" name="theorder[<?php echo $row['id']; ?>]" value="<?php echo $row['theorder']; ?>"></p>
                                        <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                                    <?php } else { ?>
                                        <p>you have no permission</p>
                                    <?php } ?>
                                </div>
                            </div>
                <?php
                        }
                    }
                    else {
                        echo '<p>no results fount</p>';
                    }
                ?>
            </div>
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <?php
                    if ($_SESSION['set_theorder'] === 'yes' OR $_SESSION['set_home_page'] === 'yes') {
                        echo '<input type="submit" value="Save settings">';
                    }
                ?>
            </div>

        </form>
    </div>
<?php

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>