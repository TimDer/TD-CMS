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
            if ($rowPermission['set_template'] === 'yes') {
                ?>


                <h1>Install a new template</h1>
                <form action="<?php echo ADMIN_URL; ?>/setings/templates-add.php" method="POST" enctype="multipart/form-data" class="row">
                    <div class="col-sm-6">
                        <p>select a template: </p>
                        <input type="file" name="upload-template" class="btn btn-default form-control" required>
                    </div>
                    <div class="col-sm-6">
                        <p>install: </p>
                        <input type="submit" class="btn btn-default form-control" name="submit" value="install template">
                    </div>
                </form>
                <hr>


                <h1>All templates</h1>
                <?php

                $tamplatesSql               = "SELECT * FROM templates";
                $tamplates_HEAD_SqlQuery    = mysqli_query($conn, $tamplatesSql);
                $tamplates_BODY_SqlQuery    = mysqli_query($conn, $tamplatesSql);
                $tamplates_MODAL_SqlQuery   = mysqli_query($conn, $tamplatesSql);

                ?>
                <div class="settings-template-head">
                    <?php           
                        while ($templatesRowCss = mysqli_fetch_assoc($tamplates_HEAD_SqlQuery)) {
                            ?>
                            <style>
                                .templates-area<?php echo $templatesRowCss['id']; ?> {
                                    background-image:    url(<?php echo BASE_URL; ?>/template/<?php echo $templatesRowCss['folder_name']; ?>/tem/tem-img.jpg);
                                    background-size:     cover;
                                    background-repeat:   no-repeat;
                                    background-position: center center;
                                }
                            </style>
                            <?php
                        }
                    ?>
                </div>
                <div class="settings-template-body">
                    <?php

                        while ($templatesRowButton = mysqli_fetch_assoc($tamplates_BODY_SqlQuery)) {
                            ?>
                            <button type="button" class="templates-area templates-area<?php echo $templatesRowButton['id']; ?>" data-toggle="modal" data-target="#idis<?php echo $templatesRowButton['id']; ?>">
                                <?php
                                    if (strlen($templatesRowButton['tem_name']) > 10) {
                                        $templatesRowButton = substr($templatesRowButton['tem_name'], 0, 10);
                                        echo $templatesRowButton . "...";
                                    }
                                    else {
                                        echo $templatesRowButton['tem_name'];
                                    }
                                ?>
                            </button>
                            <?php
                        }

                    ?>
                </div>
                <div class="settings-template-modal">
                    <?php
                        while ($templatesRowModal = mysqli_fetch_assoc($tamplates_MODAL_SqlQuery)) {
                            ?>
                            <div id="idis<?php echo $templatesRowModal["id"] ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"><?php echo $templatesRowModal["tem_name"] ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <img src="<?php echo BASE_URL; ?>/template/<?php echo $templatesRowModal["folder_name"] ?>/tem/tem-img.jpg" alt="tem-img.jpg" width="100%">
                                                </div>
                                                <div class="col-sm-6">
                                                    <?php
                                                        if (file_exists(BASE_DIR . "/template/" . $templatesRowModal["folder_name"] . "/tem/tem-info.html")) {
                                                            require BASE_DIR . "/template/" . $templatesRowModal["folder_name"] . "/tem/tem-info.html";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="<?php echo ADMIN_URL; ?>/setings/templates-delete.php?id=<?php echo $templatesRowModal['id']; ?>" class="btn btn-primary">delete the template</a>
                                            <?php
                                            
                                                if ($templatesRowModal["active_or_inactive"] === "active") {
                                                    ?>
                                                    &nbsp;&nbsp; &nbsp; &nbsp; active &nbsp; &nbsp; &nbsp;
                                                    <?php
                                                }
                                                elseif ($templatesRowModal["active_or_inactive"] === "inactive") {
                                                    ?>
                                                    <a href="<?php echo ADMIN_URL; ?>/setings/templates-active_or_inactive.php?id=<?php echo $templatesRowModal['id']; ?>" class="btn btn-primary">activate</a>
                                                    <?php
                                                }
                                            
                                            ?>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>

                <?php
                    if (isset($_GET['activetedTemplateID'])) {
                        ?>
                        <script type="text/javascript">
                            $(window).on('load',function(){
                                $('#idis<?php echo $_GET['activetedTemplateID']; ?>').modal('show');
                            });
                        </script>
                        <?php
                    }
                ?>

                <?php
            }
        }
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}