<?php

session_start();

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
            if ($rowPermission['set_template'] === 'yes') {

                // Template upload & variables
                $templateName       = $_FILES["upload-template"]["name"];
                $templateTmpName    = $_FILES["upload-template"]["tmp_name"];
                $templateError      = $_FILES["upload-template"]["error"];

                $templateSha1Hach   = sha1(time() . '?' . date('Y') . '$' . mt_rand(100000000,999999999));

                $templateExt        = explode('.', $templateName);
                $templateActualExt  = strtolower(end($templateExt));

                $templateAlloued    = array('zip');

                // SQL
                require BASE_DIR . "/db.php";
                $theTemplateName        = $templateExt[0];
                $theTemplateDirectory   = $templateSha1Hach . "--" . $templateExt[0];
                $theTempalteSql         = "INSERT INTO templates (tem_name, folder_name, active_or_inactive) VALUES ('$theTemplateName','$theTemplateDirectory','inactive')";

                // RUN
                if (in_array($templateActualExt, $templateAlloued)) {
                    $theTempalteSqlQuery = mysqli_query($conn, $theTempalteSql);

                    if ($theTempalteSqlQuery) {
                        if ($templateError === 0) {
                            // CMS ROOT/template/sample-template/
                            $templateDirectory      = BASE_DIR . "/template/" . $theTemplateDirectory;
                            // CMS ROOT/template/sample-template/sample-template.zip
                            $templateDestination    = $templateDirectory . "/" . $theTemplateDirectory . "." . $templateActualExt;
                            
                            // make a template directory
                            mkdir($templateDirectory, 0775, true);
                            // move zip file to template directory
                            move_uploaded_file($templateTmpName, $templateDestination);

                            // unzip the template
                            $templateZip        = new ZipArchive;
                            $templateOpenZip    = $templateZip->open($templateDestination);
                            if ($templateOpenZip === TRUE) {
                                $templateZip->extractTo($templateDirectory);
                                $templateZip->close();
                                unlink($templateDestination);
                                header('Location: ' . ADMIN_URL . '/setings.php?command=templates');
                            }
                            else {
                                echo 'error 4';
                            }
                        }
                        else {
                            echo 'error 3';
                        }
                    }
                    else {
                        echo 'error 2';
                    }
                }
                else {
                    echo 'error 1';
                }
            }
        }
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}