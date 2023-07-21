<?php
require_once __DIR__ . '/../src/Models/Database.php';
require_once __DIR__ . '/../src/request.php';
if (!(isset($_SESSION['email']))) {
    header('location: login.php');
    return;
}
$user = (new Database())->checkExist($_SESSION['email'])[0];
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php require_once __DIR__ . '/includes/styles.php' ?>

    <title>Admin Settings</title>
</head>

<body class="dashboard">
    <?php require_once __DIR__ . '/includes/nav.php' ?>

    <a href="./src/logout.php" class="logout">
        <i class="fas fa-arrow-right-from-bracket"></i>
    </a>
    <main id="settings">
        <?php if (isset($err)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $err ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <?php if (isset($success)) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <h4>Change your Password</h4>
        <form id="set" method="post">
            <div class="input">
                <input type="password" name="password" id="password" placeholder="">
                <label for="password">Current Password</label>
                <span class="show">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
            </div>
            <div class="input">
                <input type="password" name="newPassword" id="npassword" placeholder="">
                <label for="npassword">New Password</label>
                <span class="show">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
            </div>
            <div class="input">
                <input type="password" name="conpassword" id="cpassword" placeholder="">
                <label for="cpassword">Confirm Password</label>
                <span class="show">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
            </div>
        </form>
        <input type="submit" value="Save" name="resetPassword" form="set">
        <div class="notice">
            Last update was on <i><?= $user['updated_on'] ?></i>
        </div>
    </main>
    <?php require_once __DIR__ . '/includes/scripts.php' ?>
</body>

</html>