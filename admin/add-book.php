<?php
require_once __DIR__ . '/../src/Models/Database.php';
require_once __DIR__ . '/../src/request.php';
if (!(isset($_SESSION['email']))) {
    header('location: login.php');
    return;
}
$user = (new Database())->checkExist($_SESSION['email'])[0];
$category = (new Database())->fetchCat($user['id']);
?>
<!DOCTYPE html>
<html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <?php require_once __DIR__ . './includes/styles.php'?>

        <title>New Book</title>
    </head>

    <body class="dashboard">
        <?php require_once __DIR__ . './includes/nav.php'?>

        <main id="book">
            <form method="post" enctype="multipart/form-data">
                <?php if (isset($err)) {?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?=$err?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php }?>
                <?php if (isset($success)) {?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?=$success?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php }?>
                <div>
                    <input type="file" name="cover" id="cover" placeholder="" hidden>
                    <label for="cover">
                        <div class="chooser">
                            <img src="../assets/images/dark-bg.jpg" alt="">
                        </div>
                        Select Book Cover
                    </label>
                </div>
                <div class="input">
                    <input type="text" name="name" id="name" placeholder="" value="<?=isset($name) ? $name : ''?>">
                    <label for="name">Book Title</label>
                </div>
                <div class="input">
                    <input type="text" name="author" id="author" placeholder=""
                        value="<?=isset($author) ? $author : ''?>">
                    <label for="author">Author</label>
                </div>
                <input type="file" name="bookChooser" id="bookChooser" placeholder="" hidden>
                <label for="bookChooser" class="book-chooser">
                    Choose Book File
                </label>
                <select name="bookCategory" class="input">
                    <option value="">--Select Category--</option>
                    <?php foreach ($category as $cat) {?>
                    <option value="<?=$cat['id']?>"><?=$cat['category']?></option>
                    <?php }?>
                </select>
                <input type="submit" value="Add" name="addBook">
            </form>
        </main>
        <?php require_once __DIR__ . './includes/scripts.php'?>
    </body>

</html>