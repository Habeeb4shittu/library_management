<?php
require_once __DIR__ . './src/Models/Database.php';
require_once __DIR__ . './src/request.php';
if (!(isset($_SESSION['user_id']))) {
    header('location: login.php');
    return;
}
$user = (new Database())->checkUserIdExist($_SESSION['user_id'])[0];
$books = (new Database())->fetchAllBooks();
$liked = (new Database())->fetchLiked($_SESSION['user_id']);
$books = array_reverse($books);
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php require_once __DIR__ . './includes/styles.php' ?>

    <title><?= $user['username'] . "'s profile" ?></title>
</head>

<body id="profile">
    <a href='./src/logout.php' class='logout'>
        <i class='fas fa-arrow-right-from-bracket'></i>
    </a>
    <aside>
        <span class="toggler">
            <i class="fa fa-times" aria-hidden="true"></i>
        </span>
        <div class="user">
            <span>
                <?= substr($user['username'], 0, 1) ?>
            </span>
            <?= $user['username'] ?>
        </div>
        <ul class="side-links">
            <li><a href="#details">Profile Details</a></li>
            <li><a href="#liked">Liked Books</a></li>
            <li><a href="#settings">Settings</a></li>
            <li><a href="#resetPass">Reset Password</a></li>
            <li><a href="./books.php">Books</a></li>
        </ul>
    </aside>
    <main class="prof">
        <span class="toggler">
            <?= substr($user['username'], 0, 1) ?>
        </span>
        <section id="details">
            <h2>Profile Details</h2>
            <div class="cont">
                <div class="det">
                    <span class="tag">Firstname:</span>
                    <input type="text" readonly value="<?= $user['firstname'] ?>" disabled>
                </div>
                <div class="det">
                    <span class="tag">Lastname:</span>
                    <input type="text" readonly value="<?= $user['lastname'] ?>" disabled>
                </div>
                <div class="det">
                    <span class="tag">Username:</span>
                    <input type="text" readonly value="<?= $user['username'] ?>" disabled>
                </div>
                <div class="det">
                    <span class="tag">Email:</span>
                    <input type="text" readonly value="<?= $user['email'] ?>" disabled>
                </div>
            </div>
        </section>
        <section id="liked">
            <h2>Liked Books</h2>
            <div class="lk">
                <?php foreach ($liked as $l) { ?>
                    <?php
                    $lik = (new Database())->fetchBookDetails($l['book_id']);
                    ?>
                    <?php if ($lik) { ?>
                        <?php $lik = $lik[0]; ?>
                        <div class="bk book-ju" data-id="<?= $lik['id'] ?>" data-owner="<?= $lik['owner_id'] ?>">
                            <img src="./assets/images/<?= $lik['cover'] ?>" alt="">
                            <span>
                                <?= $lik['name'] ?>
                            </span>
                        </div>
                    <?php } ?>

                <?php } ?>
            </div>
        </section>
        <section id="settings">
            <h2>Settings</h2>
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
            <form id="userSet" method="post">
                <div class="input">
                    <input type="text" name="firstname" id="firstname" placeholder="" value="<?= isset($user['firstname']) ? $user['firstname'] : '' ?>">
                    <label for="firstname">Firstname</label>
                </div>
                <div class="input">
                    <input type="text" name="lastname" id="lastname" placeholder="" value="<?= isset($user['lastname']) ? $user['lastname'] : '' ?>">
                    <label for="lastname">Lastname</label>
                </div>
                <div class="input">
                    <input type="text" name="username" id="username" placeholder="" value="<?= isset($user['username']) ? $user['username'] : '' ?>">
                    <label for="username">Username</label>
                </div>
                <div class="input">
                    <input type="text" name="email" id="email" placeholder="" value="<?= isset($user['email']) ? $user['email'] : '' ?>">
                    <label for="email">Email</label>
                </div>
            </form>
            <input type="submit" value="Save" name="updateUser" form="userSet">
            <div class="notice">
                Last update was on <i><?= $user['updated_on'] ?></i>
            </div>
        </section>
        <section id="resetPass">
            <h2>Change Your Password</h2>
            <?php if (isset($errP)) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $errP ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <?php if (isset($successP)) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $successP ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <form id="pass" method="post">
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
            <input type="submit" value="Change" name="resetPass" form="pass">
        </section>
    </main>
    <?php require_once __DIR__ . './includes/scripts.php' ?>
</body>

</html>