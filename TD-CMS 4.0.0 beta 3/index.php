<?php 

require "start.php";
if (file_exists(BASE_DIR . "/install.php")) {
    header("Location: install.php");
}
else {
    require "includes.php";
}

