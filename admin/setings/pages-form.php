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
                    $sql    = "SELECT * FROM page ORDER BY theorder";
                    $query  = mysqli_query($conn,$sql);

                    if (mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_assoc($query)) { 
                            ?>
                            <div class="col-sm-12 pages-posts-Padding">
                                <div class="col-sm-1">
                                    <p><?php echo $row['id']; ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <p><?php echo $row['pagename']; ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <?php if ($rowPermission['set_home_page'] === 'yes') { ?>
                                        <p>
                                            Yes: <input type="radio" name="homepage[<?php echo $row['id']; ?>]" value="yes" <?php if ($row['home_page']=="yes") { echo "checked"; } ?>>
                                            No: <input type="radio" name="homepage[<?php echo $row['id']; ?>]" value="no" <?php if ($row['home_page']=="no") { echo "checked"; } ?>>
                                        </p>
                                    <?php } else { ?>
                                        <p>you have no permission</p>
                                        <input type="hidden" name="homepage[<?php echo $row['id']; ?>]" value="<?php echo $row['home_page'] ?>">
                                    <?php } ?>
                                </div>
                                <div class="col-sm-3">
                                    <?php if ($rowPermission['deletepages'] === 'yes') { ?>
                                        <!--<a href="<?php echo ADMIN_URL; ?>/setings/pages-delete.php?del-page=<?php echo $row['id']; ?>">delete: <?php echo $row['pagename']; ?></a>-->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pagedelete<?php echo $row['id']; ?>">Delete: <?php echo $row['pagename']; ?></button>
                                        <div id="pagedelete<?php echo $row['id']; ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Delete: <?php echo $row['pagename']; ?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete: <?php echo $row['pagename']; ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="<?php echo ADMIN_URL; ?>/setings/pages-delete.php?del-page=<?php echo $row['id']; ?>" class="btn btn-primary">delete: <?php echo $row['pagename']; ?></a>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <p>you have no permission</p>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php if ($rowPermission['set_theorder'] === 'yes') { ?>
                                        <p><input class="setings-pages-order" type="text" name="theorder[<?php echo $row['id']; ?>]" value="<?php echo $row['theorder']; ?>"></p>
                                    <?php } else { ?>
                                        <p>you have no permission</p>
                                        <input type="hidden" name="theorder[<?php echo $row['id']; ?>]" value="<?php echo $row['theorder']; ?>">
                                    <?php } ?>
                                    <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                                </div>
                            </div>
                            <?php
                        }
                    }
                    else {
                        echo '<p>no results fount</p>';
                    }

                    ?><br><br><br><br><br><br><br>
                    
                    <h1>Setting: posts</h1>
                    <hr>
                    <div class="col-sm-12">
                        <div class="col-sm-1"><p>ID:</p></div>
                        <div class="col-sm-2"><p>postname:</p></div>
                        <div class="col-sm-2"><p>category:</p></div>
                        <div class="col-sm-7"><p>Delete:</p></div>
                    </div>
                    <?php

                    $sqlPosts   = "SELECT * FROM posts";
                    $postsQuery = mysqli_query($conn, $sqlPosts);

                    if ($postsQuery->num_rows > 0) {
                        while ($rowPosts = mysqli_fetch_assoc($postsQuery)) {
                            ?>
                            <div class="col-sm-12 pages-posts-Padding">
                                <div class="col-sm-1">
                                    <p><?php echo $rowPosts['id']; ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <p><?php echo $rowPosts['post_name']; ?></p>
                                </div>
                                <div class="col-sm-2">
                                    <?php
                                    if ($rowPermission['edit_posts'] === 'yes') {
                                        ?>
                                        <select name="category[<?php echo $rowPosts['id']; ?>]">
                                            <?php
                                                $sqlcategory        = "SELECT * FROM page WHERE post_page!=''";
                                                $sqlQueryCategory   = mysqli_query($conn, $sqlcategory);

                                                if ($sqlQueryCategory->num_rows > 0) {
                                                    while ($rowCategory = mysqli_fetch_assoc($sqlQueryCategory)) {
                                                        ?>
                                                            <option value="<?php echo $rowCategory['post_page']; ?>" <?php if ($rowPosts['category'] === $rowCategory['post_page']) { echo 'selected="selected"'; }; ?>><?php echo $rowCategory['post_page']; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            <option value="not published" <?php if ($rowPosts['category'] === 'not published') { echo 'selected="selected"'; } ?>>not published</option>
                                        </select>
                                        <input type="hidden" name="idPosts[]" value="<?php echo $rowPosts['id']; ?>">
                                        <?php
                                    }
                                    else {
                                        echo '<p>you have no permission</p>';
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-7">
                                    <?php
                                        if ($rowPermission['delete_post'] === 'yes') {
                                            ?>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#postdelete<?php echo $rowPosts['id'] ?>">Delete: <?php echo $rowPosts['post_name'] ?></button>
                                            <div id="postdelete<?php echo $rowPosts['id'] ?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Delete: <?php echo $rowPosts['post_name'] ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to Delete: <?php echo $rowPosts['post_name'] ?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="<?php echo ADMIN_URL ?>/setings/posts-delete.php?delete=<?php echo $rowPosts['id']; ?>" class="btn btn-primary">Delete: <?php echo $rowPosts['post_name']; ?></a>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        else {
                                            echo '<p>you have no permission</p>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php   
                        }
                    }
                ?>
            </div>
            <div class="col-sm-12">
                <?php
                    if ($rowPermission['set_theorder'] === 'yes' OR $rowPermission['set_home_page'] === 'yes' OR $rowPermission['edit_posts'] === 'yes') {
                        echo '<input type="submit" name="submit-button" value="Save settings">';
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