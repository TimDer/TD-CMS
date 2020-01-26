<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    require_once BASE_DIR . '/db.php';

	if (isset($_GET['edituser'])) {

        $username           = mysqli_real_escape_string($conn, $_POST['username']);
        $password           = mysqli_real_escape_string($conn, sha1($_POST['password']));
        $delpages           = $_POST['delpages'];
        $set_home_page      = $_POST['set_home_page'];
        $set_theorder       = $_POST['set_theorder'];
        $set_footer         = $_POST['set_footer'];
        $set_css            = $_POST['set_css'];
        $add_or_edit_users  = $_POST['add_or_edit_users'];
        $delete_this_user   = $_POST['delete_this_user'];
        $userid             = $_POST['userid'];

        $sqlUser            = "UPDATE users SET user='$username',
                                                deletepages='$delpages',
                                                set_home_page='$set_home_page',
                                                set_theorder='$set_theorder',
                                                set_footer='$set_footer',
                                                set_css='$set_css',
                                                add_or_edit_users='$add_or_edit_users',
                                                delete_this_user='$delete_this_user'
                                                WHERE id='$userid'";

        if ($conn->query($sqlUser) === TRUE) {
            function redirect() {
                header('Location: ' . ADMIN_URL . '/setings.php?command=users&edit=' . $_POST['userid']);
            }
            if (!empty($_POST['password'])) {
                $sqlPass    = "UPDATE users SET password='$password'";
                if ($conn->query($sqlPass) === TRUE) {
                    redirect();
                    die();
                }
                else {
                    echo "Password error: " . $conn->error;
                }
            }
            else {
                redirect();
                die();
            }
        }
        else {
            echo "Error: " . $conn->error;
        }
    }
    elseif (isset($_GET['deluser'])) {
        $del            = $_GET['deluser'];

        $sqlDelete      = "DELETE FROM users WHERE id='$del'";

        if ($conn->query($sqlDelete) === TRUE) {
            header('Location: ' . ADMIN_URL . '/setings.php?command=users');
            die();
        }
        else {
            echo 'Error' . $conn->error;
        }
    }
    elseif (isset($_GET['adduser'])) {
        $username   = mysqli_real_escape_string($conn, $_POST['username']);
        $password   = mysqli_real_escape_string($conn, sha1($_POST['password']));

        $sqlAddUser = "INSERT INTO users (user,
                                            password,
                                            deletepages,
                                            set_home_page,
                                            set_theorder,
                                            set_footer,
                                            set_css,
                                            add_or_edit_users,
                                            delete_this_user)
                                    VALUES ('$username',
                                            '$password',
                                            'no',
                                            'no',
                                            'no',
                                            'no',
                                            'no',
                                            'no',
                                            'yes');";
        
        if ($conn->query($sqlAddUser) === TRUE) {
            header('Location: ' . ADMIN_URL . '/setings.php?command=users');
            die();
        }
        else {
            echo 'Error: ' . $conn->error;
        }
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}