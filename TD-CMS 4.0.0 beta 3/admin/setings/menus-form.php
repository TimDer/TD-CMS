<?php

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    require BASE_DIR . '/db.php';

    $idPermission = $_SESSION['id'];
    
    $sqlUserid      = "SELECT * FROM users WHERE id='$idPermission'";
    $queryUserid    = mysqli_query($conn, $sqlUserid);
    
    if ($queryUserid->num_rows > 0) {
        if ($rowPermission = mysqli_fetch_assoc($queryUserid)) {
            if ($rowPermission['menus'] === 'yes') {

                function loop_array($array = array(), $parent_id = 0) {
                    if (!empty($array[$parent_id])) {
                        foreach ($array[$parent_id] as $items) { 
                            echo '<li class="sortable-menu-li" the-order="' . $items['the_order'] . '" parent_id="' . $items['parent_id'] . '" db_id="' . $items['id'] . '">';
                            echo '<div class="sortable-menu-name">' . $items['the_name'] . '</div>';

                            /* form */

                            echo '<div class="sortable-menu-theform form-inline">';

                            echo 'Name: <input type="text" name="name[' . $items['id'] . ']" class="form-control sortable-menu-form-width sortable-menu-formtag" value="' . $items['the_name'] . '">';
                            echo 'URL: ' . BASE_URL . '/ <input type="text" name="url[' . $items['id'] . ']" class="form-control sortable-menu-form-width sortable-menu-formtag" value="' . $items['the_url'] . '">';
                            echo '<button href="' . ADMIN_URL . '/setings/menus-code.php?deleteById=' . $items['id'] . '" class="btn btn-primary sortable-menu-formtag delete-btn">Delete</button>';

                            echo '</div>';

                            /* /form */

                            echo '<ul class="sortable-menu sortable-menu-ul-sortable" parent="' . $items['id'] . '">';
                            loop_array($array, $items['id']);
                            echo '</ul>';
                            echo '</li>';
                        }
                    }
                }

                ?>
                <div class="row">
                    <div class="col-sm-4">
                    
                        <p>select a menu</p>
                        <form action="<?php echo ADMIN_URL; ?>/setings.php">
                            <input type="hidden" name="command" value="menus">

                            <?php
                            $menuNameSql        = "SELECT * FROM menus ORDER BY menu_name";
                            $menuNameSqlQuery   = mysqli_query($conn, $menuNameSql);
                            $theMenuName        = sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf");
                            ?>
                            <select name="menu_name" class="form-control" onchange="this.form.submit()">
                                <option disabled <?php if (!isset($_GET['menu_name'])) { echo 'selected'; } ?>>select a menu</option>
                                <?php
                                    if (mysqli_num_rows($menuNameSqlQuery) > 0) {
                                        while ($rowMenuName = mysqli_fetch_assoc($menuNameSqlQuery)) {
                                            if ($theMenuName != $rowMenuName['menu_name']) {
                                                ?>
                                                <option <?php if (isset($_GET['menu_name'])) {if ($_GET['menu_name'] === $rowMenuName['menu_name']) { echo "selected"; }} ?> value="<?php echo $rowMenuName['menu_name']; ?>"><?php echo $rowMenuName['menu_name']; ?></option>
                                                <?php
                                                $theMenuName = $rowMenuName['menu_name'];
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </form><br>
                        
                        <div class="addNewLinkWindow">
                            <form action="<?php echo ADMIN_URL; ?>/setings/menus-code.php" method="POST">
                                <h3 class="addNewLinkWindow-firsH3">Name:</h3>
                                <input type="test" name="addNewLink" id="addNewLink" class="form-control" required>
                                <h3>Url: <?php echo BASE_URL; ?>/</h3>
                                <input type="test" name="addNewUrl" id="addNewUrl" class="form-control" required>
                                <h3>Create or select a menu:</h3>
                                <input type="test" name="addNewMenu" id="addNewMenu" class="form-control" required>
                                <input type="submit" class="form-control btn btn-primary addNewLinkWindow-btn" name="addNew">
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-8">

                        
                    
                        <?php

                        if (isset($_GET['menu_name'])) {

                            ?>
                            <button class="btn btn-primary sortable-menu-saveButton" id="sortable-menu-submit">save</button>
                            <?php

                            $loadMenuName           = mysqli_real_escape_string($conn, $_GET['menu_name']);
                            $loadMenuSql            = "SELECT * FROM menus WHERE menu_name='$loadMenuName' ORDER BY the_order";
                            $loadMenuNameSqlQuery   = mysqli_query($conn, $loadMenuSql);

                            $array = array();

                            if (mysqli_num_rows($loadMenuNameSqlQuery) > 0) {
                                while ($rowLoadMenu = mysqli_fetch_assoc($loadMenuNameSqlQuery)) {
                                    $array[$rowLoadMenu['parent_id']][] = $rowLoadMenu;
                                }
                            }

                            
                            echo '<ul class="sortable-menu sortable-menu-ul-sortable sortable-menu-container" id="sortable-menu-container-0" parent="0">';
                            loop_array($array);
                            echo '</ul>';
                        }
                        else {
                            ?>
                            <h2>Please select a menu</h2>
                            <?php
                        }
                        

                        ?>
                    
                    </div>
                </div>
                <?php
            }
        }
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}