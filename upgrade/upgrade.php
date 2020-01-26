<?php

require 'config.php';

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

if (isset($_GET['del'])) {
    deleteDirectory(ROOT_DIR . '/upgrade');
    header('Location: ' . ADMIN_URL . '/login.php');
}
else {
    if (isset($_POST['submit'])) {
        if (file_exists(BASE_DIR . "/db.php")) {
            require_once BASE_DIR . '/db.php';

            // Delete directorys
            deleteDirectory(BASE_DIR . '/admin');
            deleteDirectory(BASE_DIR . '/functions_files');
            if (file_exists(BASE_DIR . '/download_files')) {
                rename(BASE_DIR . '/download_files' , BASE_DIR . '/downloads');
            }
            else {
                mkdir(BASE_DIR . '/downloads');
            }

            // Delete files
            unlink(BASE_DIR . '/download_helper.php');
            unlink(BASE_DIR . '/index.php');
            unlink(BASE_DIR . '/LICENCE.txt');
            unlink(BASE_DIR . '/start.php');
            unlink(BASE_DIR . '/includes.php');

            $templateZip        = new ZipArchive;
            $templateOpenZip    = $templateZip->open(UPGRADE_DIR . '/upgrade-package.zip');
            if ($templateOpenZip === TRUE) {
                $templateZip->extractTo(BASE_DIR);
                $templateZip->close();

                if (isset($_POST['submit'])) {
                    // edit start.php
                    $file_content = file(BASE_DIR . "/start.php");
                    $file_content[34] = "define('URL_DIR', '" . $_POST['installationDirectory'] . "');\n";
                
                    $start_php = fopen(BASE_DIR . "/start.php", "w+") or die("Couldn't create start.php");
                    foreach ($file_content as $file_content_number => $file_content_value) {
                        fwrite($start_php, $file_content_value);
                    }
                    fclose($start_php);
                }

                // update the database
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

                            if (!empty($_POST['installationDirectory'])) {
                                header('Location: ' . UPGRADE_URL . '/?done=true&installDir=' . $_POST['installationDirectory']);
                            }
                            else {
                                header('Location: ' . UPGRADE_URL . '/?done=true&installDir=root');
                            }
                        }
                        else {
                            echo 'error 4' . $conn->error;
                        }
                    }
                    else {
                        echo 'error 3' . $conn->error;
                    }
                }
                else {
                    echo 'error 2' . $conn->error;
                }

            }
            else {
                echo 'error 1';
            }
        }
    }
}


?>