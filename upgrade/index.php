<?php require __DIR__ . '/config.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta scarset="UTF-8">
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .width-7 {
            width: 70%
        }
        .width-8 {
            width: 80%
        }

        /* custom css */
        .center {
            margin: auto;
        }
        .content1 {
            background-color: #C4C4C4;
            min-height: 100vh;
        }
        .spase {
            padding-top: 40px;
            padding-bottom: 60px;
            padding-left: 0px;
            padding-right: 0px;
        }
        .test {
            background-color: #000000;
            height: 30px;
        }
        .warning-ul {
            color: #FF0000;
        }
    </style>
</head>

<body>
<div class="width-7 content1 center">
    <div class="width-8 center spase">
        <?php if (!isset($_GET['done'])) { ?>
            <h2>fill out the next form to upgrade TD-CMS to version 4.0.0</h2><br>
            <form action="upgrade.php" method="POST">
                <h4>
                    <?php /* =============== warning =============== */ ?>
                        <div>
                            <h3>Warning:</h3>
                            <div class="warning-ul">
                                <h4>
                                    <ul>
                                        <li>This upgrade is only supported for TD-CMS 4.0.0 beta 1 and newer</li>
                                        <li>This upgrade might override start.php</li>
                                        <li>This upgrade will delete download_helper.php (if you're running on 4.0.0 beta 1)</li>
                                        <li>Create a backup before proceeding</li>
                                    </ul>
                                </h4>
                            </div>
                        </div><br>
                    <?php /* =============== /warning =============== */ ?>
                    <?php /* =============== radio version button =============== */ ?>

                        <h3>On which version are you running?</h3>
                        <div>
                            version 4.0.0 beta 1 <input type="radio" name="version" value="4.0.0-beta-1" required> &nbsp; &nbsp; &nbsp; &nbsp;
                            version 4.0.0 beta 2 <input type="radio" name="version" value="4.0.0-beta-2" required> &nbsp; &nbsp; &nbsp; &nbsp;
                            A newer version <input type="radio" name="version" value="newer-version" required>
                        </div><br>

                    <?php /* =============== radio version button =============== */ ?>
                    <?php /* =============== Edit start.php =============== */ ?>
                        <h3>installation directory</h3>
                        <div>
                            <div class="col-sm-4">Where is TD-CMS installed:</div>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="installationDirectory" placeholder="if it's installed in the root of the server leve this empty">
                            </div>
                        </div><br><br>
                    <?php /* =============== /Edit start.php =============== */ ?>
                    <br>

                    <?php /* =============== submit button =============== */ ?>
                        <div>
                            <input class="btn btn-primary form-control" type="submit" name="submit" value="Upgrade">
                        </div>
                    <?php /* =============== /submit button =============== */ ?>
                </h4>
            </form>
        <?php } else { ?>
            <h1>the upgrade is finished</h1>
            <br><br>
            <p>We recommend to delete the upgrade directory for security of your website</p>
            <br>
            <a class="btn btn-success" href="<?php echo UPGRADE_URL; ?>/upgrade.php?del=delete-upgrade&installDir=<?php echo $_GET['installDir']; ?>">Delete "/upgrade" and go to the login page</a>
            <a class="btn btn-primary" href="<?php echo ADMIN_URL; ?>/login.php">klik here to go to the login page</a>
            <br><br>
            <?php
                if (isset($_GET["del"])) {
                    echo "<p>\"/upgrade\" has been successfully deleted</p>";
                }
            ?>
        <?php } ?>
    </div>
</div>
</body>

</html>