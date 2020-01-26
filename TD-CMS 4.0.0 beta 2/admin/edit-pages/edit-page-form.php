<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    require_once BASE_DIR . '/db.php';

    $getUrl = $_GET['edit'];

    $data = "SELECT * FROM page WHERE id = '$getUrl'";
    $result = mysqli_query($conn,$data);

    while ($row = mysqli_fetch_assoc($result)) {

        ?>

            <form action="<?php echo ADMIN_URL; ?>/edit-pages/edit-page-php.php" method="POST">
                <div class="col-sm-12">
                    <h1 class="add-edit-page h1-css">edit: <?php echo $row['pagename']; ?></h1><hr>
                    <input type="submit" name="submit-button" value="save">
                    <input type="submit" name="submit-save-and-exit-button" value="save and exit">
                </div><br><br><br>
                <div class="col-sm-3 page-spase">
                    Left sidebar name: <br><input type="text" name="lsidebarname" value="<?php echo $row['lsidebarname']; ?>"><br><br>
                    Left sidebar: <br><textarea class="mytextarea textarea-size" type="test" name="lsidebar"><?php echo $row['lsidebar']; ?></textarea><br><br>
                </div>
                <div class="col-sm-6 page-spase">
                    Pagename is: <br><input type="text" name="pagename" value="<?php echo $row['pagename']; ?>" required><br><br>
                    Content: <br><textarea class="mytextarea textarea-size" type="test" name="content"><?php echo $row['content']; ?></textarea><br><br>
                </div>
                <div class="col-sm-3 page-spase">
                    Right sidebar name: <br><input type="text" name="rsidebarname" value="<?php echo $row['rsidebarname']; ?>"><br><br>
                    Right sidebar: <br><textarea class="mytextarea textarea-size" type="test" name="rsidebar"><?php echo $row['rsidebar']; ?></textarea><br><br>
                </div>
                <div class="col-sm-12">
                    <div class="col-sm-3">
                        <?php
                            if ($rowPermission['set_home_page'] === 'yes') {
                                ?>
                                <p>is this the home page</p>
                                <input type="radio" name="homepage" value="no" <?php if ($row['home_page']=="no") { echo "checked"; } ?> required> no
                                <input type="radio" name="homepage" value="yes" <?php if ($row['home_page']=="yes") { echo "checked"; } ?> required> yes
                                <?php
                            }
                            else {
                                ?>
                                <input type="hidden" name="homepage" value="no">
                                <?php
                            }
                        ?>
                    </div>
                    <div class="col-sm-5">
                        <p>url</p>
                        <p><?php echo BASE_URL . '/ '; ?><input type="text" name="url" value="<?php echo $row['url']; ?>"><p>
                    </div>
                    <div class="col-sm-4">
                        <p>is this a post page?</p>
                        <!--  <input type="text" name="post" value="<?php echo $row['post_page']; ?>">  -->
                        <input type="radio" name="post" value="yes" <?php if ($row['post_page'] !== '') { echo 'checked'; } ?>> yes
                        <input type="radio" name="post" value="no" <?php if ($row['post_page'] == '') { echo 'checked'; } ?>> no
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <form>

        <?php

    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>