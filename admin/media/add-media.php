<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

    if (isset($_POST['submit'])) {
        // file upload
        $imageName          = $_FILES['upload-image']['name'];
        $imageTmpName       = $_FILES['upload-image']['tmp_name'];
        $imageError         = $_FILES['upload-image']['error'];

        $imageExt           = explode('.', $imageName);
        $imageActualExt     = strtolower(end($imageExt));

        $imageAlloued       = array('jpg', 'jpeg', 'png', 'gif',);

        // sql
        require BASE_DIR . "/db.php";
        $mediaName           = $imageExt[0];
        $mediaSql            = "INSERT INTO media (the_file_name, media_name) VALUES ('$imageName', '$mediaName')";
        $mediaSqlQuery       = mysqli_query($conn, $mediaSql);

        // run
        if (in_array($imageActualExt, $imageAlloued)) {
            if ($imageError === 0) {
                $imageDestination   = BASE_DIR . '/' . 'images/' . $imageName;
                move_uploaded_file($imageTmpName, $imageDestination);
                if ($mediaSqlQuery) {
                    header('Location: ' . ADMIN_URL . '/media.php');
                }
                else {
                    echo "error: " . $conn->error;
                }
            }
            else {
                echo "error code: 2";
            }
        }
        else {
            echo "Please upload a jpg, jpeg, png or a gif <br>";
            echo "error code: 1";
        }
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}