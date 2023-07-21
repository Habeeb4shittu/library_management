<?php require_once __DIR__ . '/../src/request.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once __DIR__ . '/includes/styles.php' ?>

    <title>Library Management System -- Admin Registration</title>
</head>

<body>
    <main id="register">
        <!-- <div class="bg">
                <div class="bgs"></div>
                <div class="bgs"></div>
                <div class="bgs"></div>
                <div class="bgs"></div>
            </div>
            <div class="runners">
                <div class="runner"></div>
                <div class="runner"></div>
                <div class="runner small"></div>
                <div class="runner"></div>
                <div class="runner small"></div>
            </div> -->
        <?php if (isset($err)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $err ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <h2>Admin Registration</h2>
        <form method="post">
            <div class="input">
                <input type="text" name="firstname" id="firstname" placeholder="" value="<?= isset($firstname) ? $firstname : '' ?>">
                <label for="firstname">Firstname</label>
            </div>
            <div class="input">
                <input type="text" name="lastname" id="lastname" placeholder="" value="<?= isset($lastname) ? $lastname : '' ?>">
                <label for="lastname">Lastname</label>
            </div>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="" value="<?= isset($email) ? $email : '' ?>">
                <label for="email">Email</label>
            </div>
            <div class="input">
                <input type="text" name="username" id="username" placeholder="" value="<?= isset($username) ? $username : '' ?>">
                <label for="username">Username</label>
            </div>
            <!-- <div class="input">
                <input type="password" name="access" id="access" placeholder="" value="<?= isset($access) ? $access : '' ?>">
                <label for="access">Access</label>
            </div> -->
            <div class="input">
                <input type="password" name="password" id="password" placeholder="">
                <label for="password">Password</label>
                <span class="show">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
            </div>
            <div class="input">
                <input type="password" name="conPassword" id="conPassword" placeholder="">
                <label for="conPassword">Confirm Password</label>
                <span class="show">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </span>
            </div>
            <input type="submit" value="Register" name="register">
        </form>
        <p>Already an admin? <a href="./login.php">Login</a></p>
    </main>
    <?php require_once __DIR__ . '/includes/scripts.php' ?>
</body>

</html>