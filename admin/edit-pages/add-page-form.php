<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

?>

    <form action="<?php echo ADMIN_URL ?>/edit-pages/add-page-php.php" method="POST">
        <div class="col-sm-12">
            <h1 class="add-edit-page h1-css">Add page</h1><br>
            <input type="submit" name="submit-button">
        </div><br><br><br>
        <div class="col-sm-3 page-spase">
            Left sidebar name: <br><input type="text" name="lsidebarname"><br><br>
            Left sidebar: <br><textarea class="textarea-size" type="test" name="lsidebar"></textarea><br><br>
        </div>
        <div class="col-sm-6 page-spase">
            Pagename is: <br><input type="text" name="pagename" required><br><br>
            Content: <br><textarea class="textarea-size" type="test" name="content" required></textarea><br><br>
        </div>
        <div class="col-sm-3 page-spase">
            Right sidebar name: <br><input type="text" name="rsidebarname"><br><br>
            Right sidebar: <br><textarea class="textarea-size" type="test" name="rsidebar"></textarea><br><br>
        </div>
        <div>
            <div class="col-sm-3">
                <?php
                    if ($rowPermission['set_home_page'] === 'yes') {
                        ?>
                        <p>is this the home page</p>
                        <input type="radio" name="homepage" value="no" required> no
                        <input type="radio" name="homepage" value="yes" required> yes
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
                <p><?php echo BASE_URL . '/ '; ?><input type="text" name="url"></p>
            </div>
            <div class="col-sm-4">
                <p>is this a post page?</p>
                <input type="radio" name="post" value="yes"> yes
                <input type="radio" name="post" value="no" checked> no
            </div>
        </div>
    <form>

<?php

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>