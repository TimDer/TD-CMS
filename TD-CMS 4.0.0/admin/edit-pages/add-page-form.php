<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

?>

    <form action="<?php echo ADMIN_URL ?>/edit-pages/add-page-php.php" method="POST">
        <div class="col-sm-12">
            <h1 class="add-edit-page h1-css">Add page</h1>
            <hr>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="content-erea">
                    <h3>Content: </h3>    
                    <textarea class="textarea-size textarea-size-content mytextarea" type="test" name="content"></textarea><br><br>
                </div>
                <div class="sidebars rows">
                    <div class="col-sm-6 page-spase">
                        Left sidebar name: <br><input type="text" name="lsidebarname" class="form-control"><br>
                        Left sidebar: <br><textarea class="textarea-size mytextarea" type="test" name="lsidebar"></textarea>
                    </div>
                    <div class="col-sm-6 page-spase">
                        Right sidebar name: <br><input type="text" name="rsidebarname" class="form-control"><br>
                        Right sidebar: <br><textarea class="textarea-size mytextarea" type="test" name="rsidebar"></textarea><br><br>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="page-general">
                    <h1>General</h1>
                    <b>Pagename: </b><br>
                    <input type="text" name="pagename" required class="form-control"><br>
                    <b>
                        URL:
                    </b><br>
                    <p>
                        <?php echo BASE_URL . '/ '; ?>
                        <input type="text" name="url" class="form-control">
                    </p>

                    <div class="row">
                        <div class="col-sm-6">
                            <b>post page?</b><br>
                            <input type="radio" name="post" value="yes"> yes
                            <input type="radio" name="post" value="no" checked> no
                        </div>
                        <div class="col-sm-6">
                            <?php
                                if ($rowPermission['set_home_page'] === 'yes') {
                                    ?>
                                    <b>home page?</b><br>
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
                        </div><br><br><br>
                    </div>

                    
                    
                    <input type="submit" name="submit-button" class="btn btn-block btn-success" value="Save">
                </div><br>
                <div class="page-seo">
                    <h1>SEO</h1>
                    <b>Author</b><br>
                    <input type="text" class="form-control" name="author"><br>
                    <b>Keywords</b><br>
                    <input type="text" class="form-control" name="keywords"><br>
                    <b>Description</b><br>
                    <input type="text" class="form-control" name="description">
                </div>
            </div>
        </div>
    <form>









<!--
    <form action="<?php echo ADMIN_URL ?>/edit-pages/add-page-php.php" method="POST">
        <div class="col-sm-12">
            <h1 class="add-edit-page h1-css">Add page</h1><hr>
            <input type="submit" name="submit-button">
        </div><br><br><br>
        <div class="col-sm-3 page-spase">
            Left sidebar name: <br><input type="text" name="lsidebarname"><br><br>
            Left sidebar: <br><textarea class="textarea-size" type="test" name="lsidebar"></textarea><br><br>
        </div>
        <div class="col-sm-6 page-spase">
            Pagename is: <br><input type="text" name="pagename" required><br><br>
            Content: <br><textarea class="textarea-size" type="test" name="content"></textarea><br><br>
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
-->


<?php

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>