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
            if ($rowPermission['modify_downloads'] === 'yes') {
              $downloadsSql       = "SELECT * FROM downloads ORDER BY the_file_name";
              $downloadsSqlQuery  = mysqli_query($conn, $downloadsSql);
              ?>
              <div class="container-fluid text-center">    
                <div class="row content">
                  <div class="col-sm-2 sidenav">
                    <div class="space-in-content">
                      <h4 class="text-color-white">Upload a file</h4>
                      <br>
                      <form action="<?php echo ADMIN_URL; ?>/downloads/add-file.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="upload-file" class="form-control btn btn-default" required>
                        <br><br>
                        <input type="submit" class="btn btn-default form-control" name="submit" value="Upload file">
                      </form>
                    </div>
                  </div>
                  <div class="text-field col-sm-10 text-left space-in-content">
                    <h1>Downloads</h1>
                    <hr>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>File name:</th>
                          <th>Url:</th>
                          <th>Download</th>
                          <th>Delete:</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          if ($downloadsSqlQuery->num_rows > 0) {
                            while ($rows = mysqli_fetch_assoc($downloadsSqlQuery)) {
                              ?>
                              <tr>
                                <td><?php echo $rows['the_file_name']; ?></td>
                                <td><?php echo URL_DIR; ?>/downloads/<?php echo $rows['the_file_name']; ?></td>
                                <td><a href="<?php echo BASE_URL; ?>/downloads/<?php echo $rows['the_file_name']; ?>" class="btn btn-primary">Download: <?php echo $rows['the_file_name']; ?></a></td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $rows['sha1_download']; ?>">Delete: <?php echo $rows['the_file_name']; ?></button></td>
                              </tr>
                              <?php
                            }
                          }
                          else {
                            ?>
                            <tr>
                              <td>No files found</td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                            <?php
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <?php

              $downloadsSqlModal       = "SELECT * FROM downloads ORDER BY the_file_name";
              $downloadsSqlQueryModal  = mysqli_query($conn, $downloadsSql);
              if ($downloadsSqlQueryModal->num_rows > 0) {
                while ($rowsModal = mysqli_fetch_assoc($downloadsSqlQueryModal)) {
                  ?>
                  <div id="<?php echo $rowsModal['sha1_download']; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <form action="<?php echo ADMIN_URL; ?>/downloads/delete-file.php?delete=<?php echo $rowsModal['sha1_download'] ?>" method="POST">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">Delete: <?php echo $rowsModal['the_file_name']; ?></h3>
                          </div>
                          <div class="modal-body">
                            <p>Are you sure you want to delete: <?php echo $rowsModal['the_file_name']; ?></p>
                            yes <input type="checkbox" name="yes" value="yes" required>
                          </div>
                          <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="delete">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php
                }
              }
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