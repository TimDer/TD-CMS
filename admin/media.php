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
                if ($rowPermission['modify_media'] === "yes") {
                    
                    $mediaImageSql          = "SELECT * FROM media ORDER BY id DESC";
                    $mediaImageQueryCss     = mysqli_query($conn, $mediaImageSql);
                    $mediaImageQueryButton  = mysqli_query($conn, $mediaImageSql);
                    $mediaImageQueryModal   = mysqli_query($conn, $mediaImageSql);
                    
                    ?>                    
                    <div class="container-fluid text-center">    
                      <div class="row content">
                        <div class="col-sm-2 sidenav">
                            <div class="space-in-content">
                                <h4 class="text-color-white">Upload an image</h4>
                                <br>
                                <form action="<?php echo ADMIN_URL; ?>/media/add-media.php" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="upload-image" class="form-control btn btn-default" required>
                                    <br><br>
                                    <input type="submit" class="btn btn-default form-control" name="submit" value="Upload file">
                                </form>
                            </div>
                        </div>
                        <div class="text-field col-sm-10 text-left space-in-content"> 
                          <h1>Media</h1>
                          <br>
                          <div class="media-erea">

                            <div class="media-erea-head">
                                <style>
                                    <?php
                                    
                                        while ($mediaRowCss = mysqli_fetch_assoc($mediaImageQueryCss)) {
                                            ?>
                                            .media-area-image<?php echo $mediaRowCss['id']; ?> {
                                                background-image:    url(<?php echo BASE_URL; ?>/images/<?php echo $mediaRowCss['the_file_name']; ?>);
                                                background-size:     cover;
                                                background-repeat:   no-repeat;
                                                background-position: center center;
                                            }
                                            <?php
                                        }

                                    ?>
                                    body {
                                        background-color: #fff;
                                    }
                                </style>
                            </div>

                            <div class="media-erea-body">
                                <?php

                                    while ($mediaRowButton = mysqli_fetch_assoc($mediaImageQueryButton)) {
                                        ?>
                                        <button type="button" class="media-area-image media-area-image<?php echo $mediaRowButton['id']; ?>" data-toggle="modal" data-target="#<?php echo $mediaRowButton['media_name']; ?>">
                                        <?php
                                            if (strlen($mediaRowButton['the_file_name']) > 5) {
                                                $mediaButtonResult = substr($mediaRowButton['the_file_name'], 0, 5);
                                                echo $mediaButtonResult . "...";
                                            }
                                            else {
                                                echo $mediaRowButton['the_file_name'];
                                            }
                                        ?>
                                        </button>
                                        <?php
                                    }

                                ?>
                            </div>
                          
                          </div>
                        </div>
                      </div>
                    </div>


                    <!-- Modals -->
                    <?php

                    while ($mediaRowModal = mysqli_fetch_assoc($mediaImageQueryModal)) {
                        ?>
                        <div class="modal fade" id="<?php echo $mediaRowModal['media_name']; ?>" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><?php echo $mediaRowModal['the_file_name']; ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>URL image: /images/<?php echo $mediaRowModal['the_file_name']; ?></p>
                                        <img src="<?php echo BASE_URL; ?>/images/<?php echo $mediaRowModal['the_file_name']; ?>" alt="image" class="media-modal-image">
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo ADMIN_URL; ?>/media/delete-media.php?id=<?php echo $mediaRowModal['id']; ?>" class="btn btn-primary">Delete</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                else {
                    header('Location: ' . ADMIN_URL);
                }
                require ADMIN_DIR . "/view/footer.php";
            }
        }
    }
}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>