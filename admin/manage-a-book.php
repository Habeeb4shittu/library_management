<?php
require_once __DIR__ . '/../src/Models/Database.php';
require_once __DIR__ . '/../src/request.php';
if (!(isset($_SESSION['email']))) {
    header('location: login.php');
    return;
} elseif (!(isset($_GET['bookName']))) {
    header('location: manage-book.php');
    return;
}
$user = (new Database())->checkExist($_SESSION['email'])[0];
$books = (new Database())->fetchBook($user['id']);
$category = (new Database())->fetchCat($user['id']);
$num = 0;
?>
<!DOCTYPE html>
<html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <?php require_once __DIR__ . '/includes/styles.php' ?>

        <title>Manage Book</title>
    </head>

    <body class="dashboard">
        <?php require_once __DIR__ . '/includes/nav.php' ?>

        <main class="category">
            <form class="modal-body" id="eBook" method="post" enctype="multipart/form-data">
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
                <input type="text" name="id" value="<?= $_GET['id'] ?>" hidden>
                <div class="input">
                    <input type="text" name="eName" id="editBookInp" placeholder="" value="<?= $_GET['bookName'] ?>">
                    <label for="editBookInp">Book Title</label>
                </div>
                <select name="bookCategory" class="input" id="bookCategory">
                    <option value="">--Select Category--</option>
                    <?php foreach ($category as $cat) { ?>
                    <?php if ($cat['id'] == $_GET['bookCategory']) { ?>
                    <option value="<?= $cat['id'] ?>" selected><?= $cat['category'] ?></option>
                    <?php } else { ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
                    <?php } ?>
                    <?php } ?>
                </select>
                <input type="submit" value="Add" name="subEName">

            </form>
        </main>
        <?php require_once __DIR__ . '/includes/scripts.php' ?>
    </body>

</html>