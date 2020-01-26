<?php

require_once 'start.php';

$done = FALSE;

if (isset($_POST['submit'])) {
    require_once BASE_DIR . '/db.php';

    $sqlPage = "CREATE TABLE IF NOT EXISTS page (id int(255) NOT NULL AUTO_INCREMENT,
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
        $sqlSettings = "CREATE TABLE IF NOT EXISTS settings (id int(255) NOT NULL AUTO_INCREMENT,
                                                                sidename text NOT NULL,
                                                                sideslug text NOT NULL,
                                                                footer text NOT NULL,
                                                                footerclass text NOT NULL,
                                                                customcss text NOT NULL,
                                                                PRIMARY KEY (`id`)
                                                                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
        
        if (mysqli_query($conn, $sqlSettings) === TRUE) {
            $sqlUsers = "CREATE TABLE IF NOT EXISTS users (id int(255) NOT NULL AUTO_INCREMENT,
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
                                                            delete_this_user text NOT NULL,
                                                            PRIMARY KEY (`id`)
                                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
            
            if (mysqli_query($conn, $sqlUsers) === TRUE) {
                $sidename = $_POST['sidename'];
                $sideslug = $_POST['sideslug'];

                $sqlSettingsUpdate = "INSERT INTO settings (sidename, sideslug) 
                                        VALUES ('$sidename', '$sideslug');";
                
                if (mysqli_query($conn, $sqlSettingsUpdate) === TRUE) {
                    $sqlPost = "CREATE TABLE IF NOT EXISTS posts (id int(255) NOT NULL AUTO_INCREMENT,
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
                        $delete_this_user   = mysqli_real_escape_string($conn, $_POST['delete_this_user']);

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
                                                                '$delete_this_user');";
                        
                        if (mysqli_query($conn, $sqlUsersUpdate) === TRUE) {
                            $done = TRUE;
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

?>

<!DOCTYPE html>
<html>

<head>
    <meta scarset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/bootstrap/css/bootstrap.min.css">
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
            height: 100vh;
        }
        .spase {
            padding-top: 70px;
            padding-bottom: 0px;
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
            <h1>fill out the next form to install TD-CMS</h1><br><br>
            <form action="<?php echo BASE_URL; ?>/install.php" method="POST">
                <h4>
                    <div>
                        <div class="col-sm-4">username:</div>
                        <input type="text" name="username">
                    </div><br><br><br>
                    <div>
                        <div class="col-sm-4">password:</div>
                        <input type="password" name="password">
                    </div><br><br><br>
                    <div>
                        <div class="col-sm-4">Add delete protection to this user:</div>
                        <input type="radio" name="delete_this_user" value="no" checked> yes
                        <input type="radio" name="delete_this_user" value="yes"> no
                    </div><br><br><br>
                    <div>
                        <div class="col-sm-4">sidename:</div>
                        <input type="text" name="sidename">
                    </div><br><br><br>
                    <div>
                        <div class="col-sm-4">sideslug:</div>
                        <input type="text" name="sideslug">
                    </div><br><br><br>
                    <div class="col-sm-8 pull-right"><input type="submit" name="submit" value="install"></div>
                </h4>
            </form>
        <?php } else { ?>
            <h1>the installation is finished</h1>
            <br><br>
            <p>We're recommending to delete install.php for security of your website</p>
            <br>
            <a href="<?php echo ADMIN_URL; ?>/login.php">klik here to go to the login page</a>
        <?php } ?>
    </div>
</div>
</body>

</html>