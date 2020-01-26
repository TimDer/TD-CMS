<?php

session_start();

if (!isset($start)) {
    require_once '../../../start.php';
}

if (isset($_SESSION['user'])) {

	require BASE_DIR . '/db.php';

    $idPermission = $_SESSION['id'];

    $sqlUserid      = "SELECT * FROM users WHERE id='$idPermission'";
    $queryUserid    = mysqli_query($conn, $sqlUserid);

    if ($queryUserid->num_rows > 0) {
        if ($rowPermission = mysqli_fetch_assoc($queryUserid)) {
            if ($rowPermission['menus'] === 'yes') {
                header('Content-Type: application/javascript');

                ?>
                    $(document).ready(function () {

                        // the array with all of the data
                        var menuArray = [];

                        // load sortable
                        $('.sortable-menu').sortable({
                            connectWith: '.sortable-menu',
                            update: function (event, ui) {
                                $(this).children().each(function (index, value) {
                                    // update the_order
                                    if ($(this).attr("the-order") != (index + 1)) {
                                        $(this).attr("the-order", (index + 1));
                                    }
                                });

                                $(this).children().each(function (index, value) {
                                    // update parent_id
                                    var update_parent = $(this).parent().attr("parent");

                                    $(this).attr("parent_id", update_parent);
                                });
                            }
                        });

                        // add min height
                        $('#sortable-menu-container-0').height($('#sortable-menu-container-0').height() + 50);

                        // store parent number to an array
                        $('#sortable-menu-submit').click(function () {
                            

                            $.each($(".sortable-menu-li"), function (index, value) {
                                var the_order = $(this).attr("the-order");
                                var parent_id = $(this).attr("parent_id");
                                var db_id = $(this).attr("db_id");

                                var input_name = $(".sortable-menu-formtag[name='name[" + db_id + "]']").val();
                                var input_url = $(".sortable-menu-formtag[name='url[" + db_id + "]']").val();

                                menuArray[index] = [];

                                // db_id
                                menuArray[index][0] = db_id;

                                // the_order
                                menuArray[index][1] = the_order;

                                // parent_id
                                menuArray[index][2] = parent_id;

                                // input_name
                                menuArray[index][3] = input_name;

                                // input_url
                                menuArray[index][4] = input_url;
                            });
                            //console.log(menuArray);

                            $.post(
                                "<?php echo ADMIN_URL; ?>/setings/menus-code.php",
                                {menuArray: menuArray},
                                function (data) {
                                    alert(data);
                                }
                            );
                        });



                        // Add new elements to the database
                        
                            // Add new name
                            <?php
                                // page
                                $dataNameSql                = "SELECT * FROM `page`";
                                $dataNameSqlQuery           = mysqli_query($conn, $dataNameSql);

                                // post
                                $dataNamePostSql            = "SELECT * FROM `posts`";
                                $dataNamePostSqlQuery       = mysqli_query($conn, $dataNamePostSql);

                                if ($dataNameSqlQuery->num_rows > 0 OR $dataNamePostSqlQuery->num_rows > 0) {
                                    echo "var dataName = [";
                                    // pages
                                    while ($dataNameRows = mysqli_fetch_assoc($dataNameSqlQuery)) {
                                        echo '"' . $dataNameRows['pagename'] . '",';
                                    }
                                    // posts
                                    while ($dataNamePostRows = mysqli_fetch_assoc($dataNamePostSqlQuery)) {
                                        echo '"' . $dataNamePostRows['post_name'] . '",';
                                    }
                                    echo "];" . PHP_EOL;
                                }
                                else {
                                    echo "var dataName = []" . PHP_EOL;
                                }
                            ?>

                            $('#addNewLink').autocomplete({
                                source:dataName
                            });

                            // Add new url
                            <?php
                                // page
                                $dataUrlSql                = "SELECT * FROM `page`";
                                $dataUrlSqlQuery           = mysqli_query($conn, $dataUrlSql);

                                // post
                                $dataUrlPostSql                = "SELECT * FROM `posts`";
                                $dataUrlPostSqlQuery           = mysqli_query($conn, $dataUrlPostSql);

                                if ($dataUrlSqlQuery->num_rows > 0 OR $dataUrlPostSqlQuery->num_rows > 0) {
                                    echo "var dataUrl = [";
                                    if ($dataUrlSqlQuery->num_rows > 0) {
                                        while ($dataUrlRows = mysqli_fetch_assoc($dataUrlSqlQuery)) {
                                            echo '"' . $dataUrlRows['url'] . '",';
                                        }
                                    }
                                    if ($dataUrlPostSqlQuery->num_rows > 0) {
                                        while ($dataUrlPostRows = mysqli_fetch_assoc($dataUrlPostSqlQuery)) {
                                            echo '"' . $dataUrlPostRows['category'] . '/' . $dataUrlPostRows['url'] . '",';
                                        }
                                    }
                                    echo "];" . PHP_EOL;
                                }
                                else {
                                    echo "var dataUrl = []" . PHP_EOL;
                                }
                            ?>

                            $('#addNewUrl').autocomplete({
                                source:dataUrl
                            });

                            // Add new menu
                            <?php
                                $dataMenuSql                = "SELECT * FROM `menus` ORDER BY menu_name";
                                $dataMenuSqlQuery           = mysqli_query($conn, $dataMenuSql);

                                $dataMenuSqlNumberStart     = 1;
                                $dataMenuSqlNumber          = $dataMenuSqlQuery->num_rows;
                                $theMenuName        = sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf") . sha1("dsf");

                                if ($dataMenuSqlNumber > 0) {
                                    echo "var dataMenu = [";
                                    while ($dataMenuRows = mysqli_fetch_assoc($dataMenuSqlQuery)) {
                                        if ($dataMenuSqlNumberStart === $dataMenuSqlNumber) {
                                            if ($theMenuName != $dataMenuRows['menu_name']) {
                                                echo '"' . $dataMenuRows['menu_name'] . '"';
                                                $theMenuName = $dataMenuRows['menu_name'];
                                            }
                                        }
                                        else {
                                            if ($theMenuName != $dataMenuRows['menu_name']) {
                                                echo '"' . $dataMenuRows['menu_name'] . '",';
                                                $theMenuName = $dataMenuRows['menu_name'];
                                            }
                                            $dataMenuSqlNumberStart = $dataMenuSqlNumberStart + 1;
                                        }
                                    }
                                    echo "];" . PHP_EOL;
                                }
                                else {
                                    echo "var dataMenu = []" . PHP_EOL;
                                }
                            ?>

                            $('#addNewMenu').autocomplete({
                                source:dataMenu
                            });
                        
                        $('.delete-btn').on('click', function () {
                            if (confirm("Are you sure, you want to delete this submenu")) {
                                alert = function() {};
                                $('#sortable-menu-submit').click();
                                window.location = $(this).attr("href");
                            }
                        });
                    });
                <?php
            }
        }
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>