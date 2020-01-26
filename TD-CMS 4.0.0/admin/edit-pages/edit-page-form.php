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
                    <h1 class="add-edit-page h1-css">edit: <?php echo $row['pagename']; ?></h1>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="content-erea">
                            <h3>Content: </h3>
                            <textarea class="mytextarea textarea-size textarea-size-content" type="test" name="content"><?php echo $row['content']; ?></textarea><br><br>
                        </div>
                        <div class="sidebars rows">
                            <div class="col-sm-6 page-spase">
                                Left sidebar name: <br><input type="text" name="lsidebarname" class="form-control" value="<?php echo $row['lsidebarname']; ?>"><br>
                                Left sidebar: <br><textarea class="mytextarea textarea-size" type="test" name="lsidebar"><?php echo $row['lsidebar']; ?></textarea><br><br>
                            </div>
                            <div class="col-sm-6 page-spase">
                                Right sidebar name: <br><input type="text" name="rsidebarname" class="form-control" value="<?php echo $row['rsidebarname']; ?>"><br>
                                Right sidebar: <br><textarea class="mytextarea textarea-size" type="test" name="rsidebar"><?php echo $row['rsidebar']; ?></textarea><br><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="page-general">
                            <h1>General</h1>
                            <b>Pagename: </b><br>
                            <input type="text" name="pagename" value="<?php echo $row['pagename']; ?>" required class="form-control"><br>
                            <b>
                                URL:
                            </b><br>
                            <p>
                                <?php echo BASE_URL . '/ '; ?>
                                <input type="text" name="url" class="form-control" value="<?php echo $row['url']; ?>">
                            </p>

                            <div class="row">
                                <div class="col-sm-6">
                                    <b>post page?</b><br>
                                    <input type="radio" name="post" value="yes" <?php if ($row['post_page'] !== '') { echo 'checked'; } ?>> yes
                                    <input type="radio" name="post" value="no" <?php if ($row['post_page'] == '') { echo 'checked'; } ?>> no
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                        if ($rowPermission['set_home_page'] === 'yes') {
                                            ?>
                                            <b>home page?</b><br>
                                            <input type="radio" name="homepage" value="no" <?php if ($row['home_page']=="no") { echo "checked"; } ?> required> no
                                            <input type="radio" name="homepage" value="yes" <?php if ($row['home_page']=="yes") { echo "checked"; } ?> required> yes
                                            <?php
                                        }
                                        else {
                                            ?>
                                            <input type="hidden" name="homepage" value="<?php echo $row['home_page']; ?>">
                                            <?php
                                        }
                                    ?>
                                </div><br><br><br>
                            </div>

                            
                            
                            <input type="submit" name="submit-button" class="btn btn-block btn-success" value="Save">
                            <input type="submit" name="submit-save-and-exit-button" class="btn btn-block btn-primary" value="save and exit">
                        </div><br>
                        <div class="page-seo">
                            <h1>SEO</h1>
                            <b>Author</b><br>
                            <input type="text" class="form-control" name="author" value="<?php echo $row['author']; ?>"><br>
                            <b>Keywords</b><br>
                            <input type="text" class="form-control" name="keywords" value="<?php echo $row['keywords']; ?>"><br>
                            <b>Description</b><br>
                            <input type="text" class="form-control" name="description" value="<?php echo $row['description']; ?>">
                        </div>
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