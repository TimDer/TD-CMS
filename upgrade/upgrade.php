<?php

require 'config.php';

/* ============================== default functions ============================== */

    function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }

    function getVersion($conn) {
        $versionSQL     = "SELECT * FROM settings";
        $versionQUERY   = mysqli_query($conn, $versionSQL);

        if ($versionQUERY->num_rows > 0) {
            if ($versionRow = mysqli_fetch_assoc($versionQUERY)) {
                if (isset($versionRow["cms_version"])) {
                    return $versionRow["cms_version"];
                }
                else {
                    return $_POST['version'];
                }
            }
        }
        else {
            return $_POST['version'];
        }
    }

    function extractZip($ZipArchive, $to) {
        $templateZip        = new ZipArchive;
        $templateOpenZip    = $templateZip->open($ZipArchive);
        if ($templateOpenZip === TRUE) {
            $templateZip->extractTo($to);
            $templateZip->close();

            return true;
        }
        else {
            return false;
        }
    }

/* ============================== /default functions ============================== */

/* ============================== version install functions ============================== */

    function installVersion_4_0_0_beta_2($conn) {
        // Delete directorys
        /* ============================== Delete directorys ============================== */
            deleteDirectory(BASE_DIR . '/admin');
            deleteDirectory(BASE_DIR . '/functions_files');
            if (file_exists(BASE_DIR . '/download_files')) {
                rename(BASE_DIR . '/download_files' , BASE_DIR . '/downloads');
            }
            else {
                mkdir(BASE_DIR . '/downloads');
            }
        /* ============================== Delete directorys ============================== */


        /* ============================== Delete files ============================== */
            unlink(BASE_DIR . '/download_helper.php');
            unlink(BASE_DIR . '/index.php');
            unlink(BASE_DIR . '/LICENCE.txt');
            unlink(BASE_DIR . '/start.php');
            unlink(BASE_DIR . '/includes.php');
        /* ============================== /Delete files ============================== */

        if (extractZip(UPGRADE_DIR . '/upgrade-package(4.0.0-beta-2).zip', BASE_DIR)) {
            /* ============================== edit start.php ============================== */
                $file_content = file(BASE_DIR . "/start.php");
                $file_content[34] = "define('URL_DIR', '" . $_POST['installationDirectory'] . "');\n";
            
                $start_php = fopen(BASE_DIR . "/start.php", "w+") or die("Couldn't create start.php");
                foreach ($file_content as $file_content_value) {
                    fwrite($start_php, $file_content_value);
                }
                fclose($start_php);
            /* ============================== /edit start.php ============================== */


            /* ============================== update the database ============================== */
                require BASE_DIR . "/db.php";

                $sqlMedia = "ALTER TABLE media ADD sha1_id TEXT NOT NULL AFTER media_name;";

                if (mysqli_query($conn, $sqlMedia)) {
                    $sqlUsers = "ALTER TABLE users ADD set_template TEXT NOT NULL AFTER modify_downloads;";

                    if (mysqli_query($conn, $sqlUsers)) {
                        $sqlTemplates = "CREATE TABLE templates (id int(255) NOT NULL AUTO_INCREMENT,
                                                                tem_name text NOT NULL,
                                                                folder_name text NOT NULL,
                                                                active_or_inactive text NOT NULL,
                                                                PRIMARY KEY (id)
                                                                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
                        
                        if (mysqli_query($conn, $sqlTemplates)) {

                            $sqlSelectMedia         = "SELECT * FROM media WHERE sha1_id=''";
                            $sqlSelectMediaQuery    = mysqli_query($conn, $sqlSelectMedia);
                            $sha1_id                = 1;

                            if (mysqli_num_rows($sqlSelectMediaQuery) > 0) {
                                while ($rowSha1_id = mysqli_fetch_assoc($sqlSelectMediaQuery)) {
                                    $sqlSha1_id     = sha1("7845bi8e7fc" . $sha1_id . "jfdkguye");
                                    $sha1_id = $sha1_id + 1;
                                    $theMediaID     = $rowSha1_id['id'];
                                    $sqlUpdateMedia = "UPDATE media SET sha1_id='$sqlSha1_id' WHERE id='$theMediaID'";
                                    mysqli_query($conn, $sqlUpdateMedia);
                                }
                            }

                            // done
                            return "4.0.0-beta-2";
                        }
                        else {
                            die('error 4' . $conn->error);
                        }
                    }
                    else {
                        die('error 3' . $conn->error);
                    }
                }
                else {
                    die('error 2' . $conn->error);
                }
            /* ============================== /update the database ============================== */

        }
        else {
            die('error 1');
        }
    }

    function installVersion_4_0_0_beta_3($conn) {
        // Delete directorys
        deleteDirectory(BASE_DIR . '/admin');
        deleteDirectory(BASE_DIR . '/functions_files');

        // Delete files
        unlink(BASE_DIR . '/jquery.min.js');

        if (extractZip(UPGRADE_DIR . '/upgrade-package(4.0.0-beta-3).zip', BASE_DIR)) {
            $updateSQL = "ALTER TABLE `settings` ADD `cms_version` TEXT NOT NULL AFTER `customcss`;
                -- CREATE the menus table
                CREATE TABLE `menus` (`id` int(255) NOT NULL AUTO_INCREMENT,
                                        `the_name` text NOT NULL,
                                        `the_url` text NOT NULL,
                                        `the_order` int(255) NOT NULL,
                                        `parent_id` int(255) NOT NULL,
                                        `menu_name` text NOT NULL,
                                        PRIMARY KEY (`id`)
                                        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
                
                -- ADD the menus to the users table
                ALTER TABLE `users` ADD `menus` TEXT NOT NULL AFTER `set_template`;

                -- ADD the SEO to the page table
                ALTER TABLE `page` ADD `author` TEXT NOT NULL AFTER `url`;
                ALTER TABLE `page` ADD `keywords` TEXT NOT NULL AFTER `author`;
                ALTER TABLE `page` ADD `description` TEXT NOT NULL AFTER `keywords`;

                -- ADD the SEO to the posts table
                ALTER TABLE `posts` ADD `author` TEXT NOT NULL AFTER `post_3`;
                ALTER TABLE `posts` ADD `keywords` TEXT NOT NULL AFTER `author`;
                ALTER TABLE `posts` ADD `description` TEXT NOT NULL AFTER `keywords`;

                -- ADD permissions (no) to all users for the menu
                UPDATE users SET menus='no' WHERE menus='';

                -- ADD permissions (no) to all users for the template
                UPDATE users SET set_template='no' WHERE set_template='';
                
                -- ADD the version to the database
                UPDATE settings SET cms_version='4.0.0 beta 3' WHERE cms_version='';
            ";

            if (mysqli_multi_query($conn, $updateSQL)) {
                // done and return the version
                return "4.0.0 beta 3";
            }
            else {
                die('error 2' . $conn->error);
            }

        }
        else {
            die('error 1');
        }
    }

    function installVersion_4_0_0($conn) {
        // Delete directorys
        deleteDirectory(BASE_DIR . '/admin');

        if (extractZip(UPGRADE_DIR . '/upgrade-package(4.0.0).zip', BASE_DIR)) {
            $sqlUpdate = "UPDATE settings SET cms_version='4.0.0' WHERE cms_version='4.0.0 beta 3'";

            if (mysqli_query($conn, $sqlUpdate)) {
                // done and return the version
                return "4.0.0";
            }
            else {
                die('error 2' . $conn->error);
            }
        }
        else {
            die('error 1');
        }
    }

/* ============================== /version install functions ============================== */


/* ============================== run install functions ============================== */

    function runTheUpdate($conn) {
        // get the instaled version
        $version = getVersion($conn);

        // install version 4.0.0 beta 2
        if ($version === "4.0.0-beta-1") {
            $version = installVersion_4_0_0_beta_2($conn);
        }

        //install version 4.0.0 beta 3
        if ($version === "4.0.0-beta-2") {
            $version = installVersion_4_0_0_beta_3($conn);
        }

        // reload the conn var
        $conn->close();
        require BASE_DIR . "/db.php";
        
        //install version 4.0.0
        if ($version === "4.0.0 beta 3") {
            $version = installVersion_4_0_0($conn);
        }

        return $version;
    }

    function redirectTheUserBackToTheRoot($done) {
        if ($done) {
            if (!empty($_POST['installationDirectory'])) {
                header('Location: ' . UPGRADE_URL . '/?done=true&installDir=' . $_POST['installationDirectory']);
            }
            else {
                header('Location: ' . UPGRADE_URL . '/?done=true&installDir=root');
            }
        }
        else {
            die("something went wrong");
        }
    }

/* ============================== run install functions ============================== */

// run
if (isset($_GET['del'])) {
    deleteDirectory(ROOT_DIR . '/upgrade');
    header('Location: ' . ADMIN_URL . '/login.php');
}
else {
    if (isset($_POST['submit'])) {
        if (file_exists(BASE_DIR . "/db.php")) {
            require_once BASE_DIR . "/db.php";
            $done = runTheUpdate($conn);
            
            redirectTheUserBackToTheRoot($done);
        }
    }
}