<?php

if (isset($_POST['submit'])) {
    // edit start.php
    $file_content = file("./start.php");
    $file_content[34] = "define('URL_DIR', '" . $_POST['installationDirectory'] . "');\n";

    $start_php = fopen("./start.php", "w+") or die("Couldn't create start.php");
    foreach ($file_content as $file_content_number => $file_content_value) {
        fwrite($start_php, $file_content_value);
    }
    fclose($start_php);
    
    // require start.php
    require_once 'start.php';
}
else {
    require_once 'start.php';
}

$done = FALSE;

if (isset($_GET['del'])) {
    unlink(BASE_DIR . "/install.php");
    $done = TRUE;
}
else {
    if (isset($_POST['submit'])) {
        // create db.php
        $db_php     = fopen("db.php", "w") or die("Couldn't create db.php");

        fwrite($db_php, "<?php\n");
        fwrite($db_php, "\n");
        fwrite($db_php, "\$servername	= \"" . $_POST['serverhostname'] . "\";\n");
        fwrite($db_php, "\$username	= \"" . $_POST['sqlusername'] . "\";\n");
        fwrite($db_php, "\$password	= \"" . $_POST['sqlpassword'] . "\";\n");
        fwrite($db_php, "\$dbname		= \"" . $_POST['sqldatabasname'] . "\";\n");
        fwrite($db_php, "\n");
        fwrite($db_php, "// create connection\n");
        fwrite($db_php, "\$conn = mysqli_connect(\$servername, \$username, \$password ,\$dbname);\n");
        fwrite($db_php, "\n");
        fwrite($db_php, "// Check connection\n");
        fwrite($db_php, "if (!\$conn) {\n");
        fwrite($db_php, "    die(\"Connection failed: \" . \$conn->connect_error);\n");
        fwrite($db_php, "}");
        fwrite($db_php, "\n");
        fwrite($db_php, "//echo \"<p>connection to the database was successfully</p>\";");

        fclose($db_php);

        if (file_exists(BASE_DIR . "/db.php")) {
            require_once BASE_DIR . '/db.php';

            $sqlPage = "CREATE TABLE page (id int(255) NOT NULL AUTO_INCREMENT,
                                            pagename varchar(100) NOT NULL,
                                            content text NOT NULL,
                                            lsidebarname varchar(50) NOT NULL,
                                            rsidebarname varchar(50) NOT NULL,
                                            lsidebar text NOT NULL,
                                            rsidebar text NOT NULL,
                                            home_page varchar(3) NOT NULL,
                                            url text NOT NULL,
                                            theorder int(255) NOT NULL,
                                            post_page text NOT NULL,
                                            PRIMARY KEY (`id`)
                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1";

            if (mysqli_query($conn, $sqlPage) === TRUE) {
                $sqlSettings = "CREATE TABLE settings (id int(255) NOT NULL AUTO_INCREMENT,
                                                        sidename text NOT NULL,
                                                        sideslug text NOT NULL,
                                                        footer text NOT NULL,
                                                        footerclass text NOT NULL,
                                                        customcss text NOT NULL,
                                                        PRIMARY KEY (`id`)
                                                        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
                
                if (mysqli_query($conn, $sqlSettings) === TRUE) {
                    $sqlUsers = "CREATE TABLE users (id int(255) NOT NULL AUTO_INCREMENT,
                                                    user text NOT NULL,
                                                    password text NOT NULL,
                                                    deletepages text NOT NULL,
                                                    set_home_page text NOT NULL,
                                                    set_theorder text NOT NULL,
                                                    set_footer text NOT NULL,
                                                    set_css text NOT NULL,
                                                    edit_pages text NOT NULL,
                                                    add_pages text NOT NULL,
                                                    edit_posts text NOT NULL,
                                                    add_posts text NOT NULL,
                                                    delete_post text NOT NULL,
                                                    edit_general_settings text NOT NULL,
                                                    add_or_edit_users text NOT NULL,
                                                    `modify_media` text NOT NULL,
                                                    `modify_downloads` text NOT NULL,
                                                    `set_template` text NOT NULL,
                                                    delete_this_user text NOT NULL,
                                                    PRIMARY KEY (`id`)
                                                    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
                    
                    if (mysqli_query($conn, $sqlUsers) === TRUE) {
                        $sidename = $_POST['sidename'];
                        $sideslug = $_POST['sideslug'];

                        $sqlSettingsUpdate = "INSERT INTO `settings` (`id`, `sidename`, `sideslug`, `footer`, `footerclass`, `customcss`) VALUES (NULL, '$sidename', '$sideslug', '', '', '');";
                        
                        if (mysqli_query($conn, $sqlSettingsUpdate) === TRUE) {
                            $sqlPost = "CREATE TABLE posts (id int(255) NOT NULL AUTO_INCREMENT,
                                                            category varchar(100) NOT NULL,
                                                            post_name text NOT NULL,
                                                            post_1 text NOT NULL,
                                                            post_2 text NOT NULL,
                                                            post_3 text NOT NULL,
                                                            date_added text NOT NULL,
                                                            date_edited text NOT NULL,
                                                            url text NOT NULL,
                                                            PRIMARY KEY (`id`)
                                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
                            
                            if (mysqli_query($conn, $sqlPost)) {
                                $username           = mysqli_real_escape_string($conn, $_POST['username']);
                                $password           = mysqli_real_escape_string($conn, sha1($_POST['password']));

                                $sqlUsersUpdate = "INSERT INTO `users` (user,
                                                                        password,
                                                                        deletepages,
                                                                        set_home_page,
                                                                        set_theorder,
                                                                        set_footer,
                                                                        set_css,
                                                                        edit_pages,
                                                                        add_pages,
                                                                        edit_posts,
                                                                        add_posts,
                                                                        delete_post,
                                                                        edit_general_settings,
                                                                        add_or_edit_users,
                                                                        modify_media,
                                                                        modify_downloads,
                                                                        set_template,
                                                                        delete_this_user)
                                                                        VALUES
                                                                        ('$username',
                                                                        '$password',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'yes',
                                                                        'no');";
                                
                                if (mysqli_query($conn, $sqlUsersUpdate) === TRUE) {
                                    $sqlDownloads   = "CREATE TABLE `downloads` (`id` int(255) NOT NULL AUTO_INCREMENT,
                                                                                `the_file_name` text NOT NULL,
                                                                                `sha1_download` text NOT NULL,
                                                                                PRIMARY KEY (`id`)
                                                                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

                                    if (mysqli_query($conn, $sqlDownloads)) {
                                        $sqlMedia   = "CREATE TABLE `media` (`id` int(255) NOT NULL AUTO_INCREMENT,
                                                                            `the_file_name` text NOT NULL,
                                                                            `media_name` text NOT NULL,
                                                                            `sha1_id` text NOT NULL,
                                                                            PRIMARY KEY (`id`)
                                                                            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

                                        if (mysqli_query($conn, $sqlMedia)) {
                                            $sqlTemplates = "CREATE TABLE `templates` (`id` int(255) NOT NULL AUTO_INCREMENT,
                                                                                        `tem_name` text NOT NULL,
                                                                                        `folder_name` text NOT NULL,
                                                                                        `active_or_inactive` text NOT NULL,
                                                                                        PRIMARY KEY (`id`)
                                                                                        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";

                                            if (mysqli_query($conn, $sqlTemplates)) {
                                                $done = TRUE;
                                            }
                                        }
                                    }
                                    else {
                                        echo 'sqlDownloads: ' . $conn->error;
                                    }
                                }
                                else {
                                    echo 'sqlUsersUpdate Error: ' . $conn->error;
                                }
                            }
                            else {
                                echo 'sqlPost error: ' . $conn->error;
                            }
                        }
                        else {
                            echo 'sqlSettingsUpdate Error: ' . $conn->error;
                        }
                    }
                    else {
                        echo 'sqlUsersPrimaryKey Error: ' . $conn->error;
                    }
                }
                else {
                    echo 'sqlSettings Error: ' . $conn->error;
                }
            }
            else {
                echo 'sqlPage Error: ' . $conn->error;
            }
        }
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta scarset="UTF-8">
    <link rel="stylesheet" type="text/css" href="admin/bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .width-7 {
            width: 70%
        }
        .width-8 {
            width: 80%
        }

        /* custom css */
        .center {
            margin: auto;
        }
        .content1 {
            background-color: #C4C4C4;
            min-height: 100vh;
        }
        .spase {
            padding-top: 40px;
            padding-bottom: 60px;
            padding-left: 0px;
            padding-right: 0px;
        }
        .test {
            background-color: #000000;
            height: 30px;
        }
    </style>
</head>

<body>
<div class="width-7 content1 center">
    <div class="width-8 center spase">
        <?php if ($done === FALSE) { ?>
            <h1>fill out the next form to install TD-CMS</h1><br>
            <form action="install.php" method="POST">
                <h4>
                    <?php /* =============== general settings =============== */ ?>
                        <div>
                            <div class="col-sm-4">username:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="username" required>
                            </div>
                        </div><br><br>
                        <div>
                            <div class="col-sm-4">password:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="password" name="password" required>
                            </div>
                        </div><br><br>
                        <div>
                            <div class="col-sm-4">sidename:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="sidename" required>
                            </div>
                        </div><br><br>
                        <div>
                            <div class="col-sm-4">sideslug:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="sideslug" required>
                            </div>
                        </div><br>
                    <?php /* =============== /general settings =============== */ ?>
                    <br>
                    <?php /* =============== Create db.php =============== */ ?>
                        <h1>Make a connection to the database</h1>
                        <div>
                            <div class="col-sm-4">Server host name:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="serverhostname" value="localhost" required>
                            </div>
                        </div><br><br>
                        <div>
                            <div class="col-sm-4">sql username:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="sqlusername" required>
                            </div>
                        </div><br><br>
                        <div>
                            <div class="col-sm-4">sql password:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="password" name="sqlpassword" required>
                            </div>
                        </div><br><br>
                        <div>
                            <div class="col-sm-4">sql databasname:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="sqldatabasname" required>
                            </div>
                        </div><br><br>
                    <?php /* =============== /Create db.php =============== */ ?>
                    <?php /* =============== Edit start.php =============== */ ?>
                        <h1>config / start.php</h1>
                        <div>
                            <div class="col-sm-4">installation directory:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="installationDirectory" placeholder="Leave this empty if you want to install TD-CMS in the root">
                            </div>
                        </div><br><br>
                    <?php /* =============== Edit start.php =============== */ ?>
                    <br>

                    <div>
                        <input class="btn btn-primary form-control" type="submit" name="submit" value="install">
                    </div>
                </h4>
            </form>
        <?php } else { ?>
            <h1>the installation is finished</h1>
            <br><br>
            <p>We recommend to delete install.php for security of your website</p>
            <br>
            <a class="btn btn-success" href="<?php echo BASE_URL; ?>/install.php?del=delete-install">Delete install.php</a>
            <a class="btn btn-primary" href="<?php echo ADMIN_URL; ?>/login.php">klik here to go to the login page</a>
            <br><br>
            <?php
                if (isset($_GET["del"])) {
                    echo "<p>install.php has been successfully deleted</p>";
                }
            ?>
        <?php } ?>
    </div>
</div>
</body>

</html>