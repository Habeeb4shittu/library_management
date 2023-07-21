<?php
require_once __DIR__ . '/../src/request.php';
if (isset($_SESSION['email'])) {
    header('location: /admin/');
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php require_once __DIR__ . '/includes/styles.php' ?>
        <title>Library Management System -- Admin Login</title>
    </head>

    <body>
        <main id="register" class="login">
            <?php if (isset($err)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $err ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>
            <h2>Admin Login</h2>
            <form method="post">
                <div class="input">
                    <input type="email" name="email" id="email" placeholder=""
                        value="<?= isset($email) ? $email : '' ?>">
                    <label for="email">Email</label>
                </div>
                <div class="input">
                    <input type="password" name="password" id="password" placeholder="">
                    <label for="password">Password</label>
                    <span class="show">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="submit" value="Login" name="login">
            </form>
            <p>Not an admin? <a href="./register.php">Register</a></p>
        </main>
        <?php require_once __DIR__ . '/includes/scripts.php' ?>
    </body>

</html>