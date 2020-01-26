<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    require BASE_DIR . '/db.php';

    $edit       = $_GET['edit'];

    $sqlPosts   = "SELECT * FROM posts WHERE id='$edit'";
    $sqlQuery   = mysqli_query($conn, $sqlPosts);

    if ($sqlQuery->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($sqlQuery)) {
            ?>

            <form action="<?php echo ADMIN_URL; ?>/edit-posts/edit-posts.php" method="post">
                <h3 class="row">
                    <div class="col-sm-12 form-container">
                        <div class="col-sm-2">
                            <input type="submit" value="Save" class="btn btn-success btn-lg">
                        </div>
                    </div>
                    <div class="col-sm-12 form-container">
                        <div class="col-sm-2">
                            select a category:
                        </div>
                        <div class="col-sm-10">
                            <?php echo BASE_URL; ?>
                            /
                            <select name="category">
                                <?php
                                    $sqlcategory        = "SELECT * FROM page WHERE post_page!=''";
                                    $sqlQueryCategory   = mysqli_query($conn, $sqlcategory);

                                    if ($sqlQueryCategory->num_rows > 0) {
                                        while ($rowCategory = mysqli_fetch_assoc($sqlQueryCategory)) {
                                            ?>
                                                <option value="<?php echo $rowCategory['post_page']; ?>" <?php if ($row['category'] === $rowCategory['post_page']) { echo 'selected="selected"'; }; ?>><?php echo $rowCategory['post_page']; ?></option>';
                                            <?php
                                        }
                                    }
                                ?>
                                <option value="not published" <?php if ($row['category'] === 'not published') { echo 'selected="selected"'; } ?>>not published</option>
                            </select>
                            /
                            <input type="text" name="url" value="<?php echo $row['url']; ?>">
                        </div>
                    </div>
                    <div class="col-sm-12 form-container">
                        <div class="col-sm-2">
                            POST Name:
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="post_name" value="<?php echo htmlentities($row['post_name']); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12 form-container">
                        <div class="col-sm-2">
                            POST lable 1:
                        </div>
                        <div class="col-sm-10">
                            <textarea rows="6" name="POST_lable_1"><?php echo htmlentities($row['post_1']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 form-container">
                        <div class="col-sm-2">
                            POST lable 2:
                        </div>
                        <div class="col-sm-10">
                            <textarea rows="6" name="POST_lable_2"><?php echo htmlentities($row['post_2']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 form-container">
                        <div class="col-sm-2">
                            POST lable 3:
                        </div>
                        <div class="col-sm-10">
                            <textarea class="mytextarea" rows="16" name="POST_lable_3"><?php echo htmlentities($row['post_3']); ?></textarea>
                        </div>
                    </div>
                </h3>
                <div class="post-seo">
                    <h1>SEO</h1>
                    <b>Author</b><br>
                    <input type="text" class="form-control" name="author" value="<?php echo $row['author']; ?>"><br>
                    <b>Keywords</b><br>
                    <input type="text" class="form-control" name="keywords" value="<?php echo $row['keywords']; ?>"><br>
                    <b>Description</b><br>
                    <input type="text" class="form-control" name="description" value="<?php echo $row['description']; ?>">
                </div>
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            </form>

            <?php
        }
    }
    else {
        echo "<h1>Whoops we haven't found what you're looking for</h1>";
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>