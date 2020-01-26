<?php 

if (!isset($start)) {
    require_once '../start.php';
}
require ADMIN_DIR . "/view/header.php"; 

if (isset($_SESSION['user'])) {
    if ($_SESSION['time'] < time() - (60 * 15)) {
        header('Location: ' . ADMIN_URL . '/login.php?logout=logout');
    }
    else {
        $_SESSION['time'] = time();
        
        require BASE_DIR . '/db.php';

        $idPermission = $_SESSION['id'];

        $sqlUserid      = "SELECT * FROM users WHERE id='$idPermission'";
        $queryUserid    = mysqli_query($conn, $sqlUserid);

        if ($queryUserid->num_rows > 0) {
            if ($rowPermission = mysqli_fetch_assoc($queryUserid)) {
                if ($rowPermission['deletepages'] === 'yes' OR $rowPermission['set_home_page'] === 'yes' OR $rowPermission['set_theorder'] === 'yes' OR $rowPermission['set_footer'] === 'yes' OR $rowPermission['set_css'] === 'yes' OR $rowPermission['edit_posts'] === 'yes' OR $rowPermission['delete_post'] === 'yes' OR $rowPermission['edit_general_settings'] === 'yes' OR $rowPermission['add_or_edit_users'] === 'yes') {
                    ?>
                    <div class="container-fluid text-center">    
                        <div class="row content">
                            <div class="col-sm-2 sidenav">
                                <div class="space-in-content sidebar-admin-panel">
                                    <?php require ADMIN_DIR . '/setings/sidebar.php'; ?>
                                </div>
                            </div>
                            <div class="div-full col-sm-10 text-field">
                                <div class="text-field text-left space-in-content"> 
                                    <h1>
                                        Setting: 
                                        <?php if (isset($_GET['command'])) { echo $_GET['command']; } else { echo 'general'; } ?>
                                    </h1>
                                    <hr>
                                    <?php 
                                        function general() {
                                            global $start;
                                            global $rowPermission;
                                            if ($rowPermission['edit_general_settings'] === 'yes') {
                                                require ADMIN_DIR . '/setings/general-form.php';
                                            }
                                        }
                                        if (isset($_GET['command'])) {                                        
                                            if ($_GET['command']=="pages") {
                                                require ADMIN_DIR . '/setings/pages-form.php';
                                            }
                                            elseif ($_GET['command']=="footer" AND $rowPermission['set_footer'] === 'yes') {
                                                require ADMIN_DIR . '/setings/footer-form.php';
                                            }
                                            elseif ($_GET['command']=="general") {
                                                general();
                                            }
                                            elseif ($_GET['command']=="custom-css" AND $rowPermission['set_css'] === 'yes') {
                                                require ADMIN_DIR . '/setings/custom-css-form.php';
                                            }
                                            elseif ($_GET['command']=="users" AND $rowPermission['add_or_edit_users'] === 'yes') {
                                                if (isset($_GET['edit'])) {
                                                    require ADMIN_DIR . '/setings/users-form/edit-users-form.php';
                                                }
                                                else {
                                                    require ADMIN_DIR . '/setings/users-form/users-form.php';
                                                }
                                            }
                                        }
                                        else {
                                            general();
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                else {
                    header('Location: ' . ADMIN_URL);
                }
            }
        }
        require ADMIN_DIR . "/view/footer.php";
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>