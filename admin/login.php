<?php

session_start();

require "../start.php";

require BASE_DIR . "/db.php";

if (isset($_POST['login'])) {
    if (empty($_POST['username']) or empty($_POST['password'])) {
        header('Location: ' . ADMIN_URL . '/login.php?login=empty');
        die();
    }
    else {
        $username       = mysqli_real_escape_string($conn, $_POST['username']);
        $password       = mysqli_real_escape_string($conn, sha1($_POST['password']));

        $sqlLogin       = "SELECT * FROM users WHERE user='$username'";
        $query          = mysqli_query($conn, $sqlLogin);
        $resultCheck    = mysqli_num_rows($query);

        if (!$resultCheck > 0) {
            header('Location: ' . ADMIN_URL . '/login.php?login=error');
            die();
        }
        else {
            if ($row = mysqli_fetch_assoc($query)) {
                if ($password === $row['password']) {
                    $_SESSION['user'] = $row['user'];
                    $_SESSION['deletepages'] = $row['deletepages'];
                    $_SESSION['set_home_page'] = $row['set_home_page'];
                    $_SESSION['set_theorder'] = $row['set_theorder'];
                    $_SESSION['set_footer'] = $row['set_footer'];
                    $_SESSION['set_css'] = $row['set_css'];
                    $_SESSION['add_or_edit_users'] = $row['add_or_edit_users'];
                    $_SESSION['time'] = time();
                    header('Location: ' . ADMIN_URL);
                }
                else {
                    header("Location: " . ADMIN_URL . "/login.php?login=error");
					exit();
                }
            }
        }
    }
}
elseif (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ' . ADMIN_URL . '/login.php');
}
elseif (isset($_SESSION['user'])) {
    header('Location: ' . ADMIN_URL);
}
?>

<!DOCTYPE html>
<html lang="EN">
	<head>
		<meta charset="UTF-8">
		<title>login to TD-CMS</title>
        <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>/login.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
        <div class="container">
            <div class="card card-container">
                <img id="profile-img" class="profile-img-card" src="<?php echo BASE_URL; ?>/images/login.png" />
                <p id="profile-name" class="profile-name-card"></p>
                <?php if (!isset($_SESSION['user'])) { ?>
                    <form class="form-signin" action="<?php echo ADMIN_URL; ?>/login.php" method="POST">
                        <span id="reauth-email" class="reauth-email"></span>
                        <input name="username" type="text" id="inputEmail" class="form-control" placeholder="Username">
                        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password">
                        <button name="login" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
                    </form>
                    <a href="<?php echo BASE_URL; ?>">go back to the home page</a>
                <?php } else { ?>
                    <p>You are already logged in</p>
                    <form action="<?php echo ADMIN_URL; ?>/login.php" method="GET">
                        <input class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="logout" value=" logout ">
                    </form><br>
                    <a href="<?php echo BASE_URL; ?>">Go to the home page</a><br><br>
                    <a href="<?php echo ADMIN_URL; ?>">go to the admin section</a>
                <?php } ?>
            </div>
        </div>
	</body>
</html>
