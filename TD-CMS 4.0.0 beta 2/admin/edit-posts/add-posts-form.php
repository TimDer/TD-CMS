<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    ?>

    <form action="<?php echo ADMIN_URL ?>/edit-posts/add-posts.php" method="post">
        <h3>
            <input type="submit" value="Save">
            <br><br>
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
                                    echo '<option value="' . $rowCategory['post_page'] . '">' . $rowCategory['post_page'] . '</option>';
                                }
                            }
                        ?>
                        <option value="not published">not published</option>
                    </select>
                    /
                    <input type="text" name="url">
                </div>
            </div>
            <div class="col-sm-12 form-container">
                <div class="col-sm-2">
                    POST Name:
                </div>
                <div class="col-sm-10">
                    <input type="text" name="post_name">
                </div>
            </div>
            <div class="col-sm-12 form-container">
                <div class="col-sm-2">
                    POST lable 1:
                </div>
                <div class="col-sm-10">
                    <textarea rows="6" name="POST_lable_1"></textarea>
                </div>
            </div>
            <div class="col-sm-12 form-container">
                <div class="col-sm-2">
                    POST lable 2:
                </div>
                <div class="col-sm-10">
                    <textarea rows="6" name="POST_lable_2"></textarea>
                </div>
            </div>
            <div class="col-sm-12 form-container">
                <div class="col-sm-2">
                    POST lable 3:
                </div>
                <div class="col-sm-10">
                    <textarea rows="6" name="POST_lable_3"></textarea>
                </div>
            </div>
        </h3>
    </form>

    <?php

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>