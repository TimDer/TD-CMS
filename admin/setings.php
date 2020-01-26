<?php 

if (!isset($start)) {
    require_once '../start.php';
}
require BASE_DIR . "/db.php";
require ADMIN_DIR . "/view/header.php"; 

if (isset($_SESSION['user'])) {
    if ($_SESSION['time'] < time() - (60 * 15)) {
        header('Location: ' . ADMIN_URL . '/login.php?logout=logout');
    }
    else {
        $_SESSION['time'] = time();
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
                        
                            if (isset($_GET['command'])) {
                                if ($_GET['command']=="pages") {
                                    require ADMIN_DIR . '/setings/pages-form.php';
                                }
                                elseif ($_GET['command']=="footer" AND $_SESSION['set_footer'] === 'yes') {
                                    require ADMIN_DIR . '/setings/footer-form.php';
                                }
                                elseif ($_GET['command']=="general") {
                                    require ADMIN_DIR . '/setings/general-form.php';
                                }
                                elseif ($_GET['command']=="custom-css" AND $_SESSION['set_css'] === 'yes') {
                                    require ADMIN_DIR . '/setings/custom-css-form.php';
                                }
                                elseif ($_GET['command']=="users" AND $_SESSION['add_or_edit_users'] === 'yes') {
                                    if (isset($_GET['edit'])) {
                                        require ADMIN_DIR . '/setings/users-form/edit-users-form.php';
                                    }
                                    else {
                                        require ADMIN_DIR . '/setings/users-form/users-form.php';
                                    }
                                }
                            }
                            else {
                                require ADMIN_DIR . '/setings/general-form.php';
                            }

                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php

        require ADMIN_DIR . "/view/footer.php";
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>