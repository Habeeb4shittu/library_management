<?php
session_start();
require_once __DIR__ . '/src/Models/Database.php';
if (!(isset($_SESSION['user_id']))) {
    header('location: login.php');
    return;
} elseif (!(isset($_GET['id']))) {
    header('location: books.php');
    return;
}
$user = (new Database())->checkUserIdExist($_SESSION['user_id'])[0];
$book = (new Database())->fetchBookDetails($_GET['id'])[0];
// print_r($book);
?>
<!DOCTYPE html>
<html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <?php require_once __DIR__ . '/includes/styles.php' ?>

        <title><?= $book['name'] ?></title>
    </head>

    <body id="bp">
        <a href='./src/logout.php' class='logout'>
            <i class='fas fa-arrow-right-from-bracket'></i>
        </a>
        <main id='bookPage'>
            <div class="image">
                <img src="./assets/images/<?= $book['cover'] ?>" alt="">
            </div>
            <div class="details">
                <a href="./books.php"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
                <div>
                    Author: <span><?= $book['author'] ?></span>
                </div>
                <div>
                    Title: <span><?= $book['name'] ?></span>
                </div>
                <div>
                    Uploaded By: <span>
                        <?php
                    $admin = (new Database())->checkIdExist($book['owner_id'])[0];
                    ?>
                        <?= $admin['username'] ?>
                    </span>
                </div>
                <div>
                    Category: <span>
                        <?= (new Database())->fetchCatDetails($book['category_id'])[0]['category'] ?>
                    </span>
                </div>
                <div>
                    Likes: <span><?= $book['likes'] ?></span>
                </div>
                <div>
                    Uploaded On: <span><?= $book['uploaded_on'] ?></span>
                </div>
                <div>
                    Updated On: <span><?= $book['modified_on'] ?></span>
                </div>
                <div class="funcs">
                    <div>
                        <?php
                    $liked = (new Database())->checkLikedBook($book['id'], $_SESSION['user_id']);
                    ?>
                        <?php if ($liked) { ?>
                        <span class="like red" data-id="<?= $book['id'] ?>" data-owner="<?= $book['owner_id'] ?>"
                            onclick="Like()">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                        </span>
                        <?php } else { ?>
                        <span class="like" data-id="<?= $book['id'] ?>" data-owner="<?= $book['owner_id'] ?>"
                            onclick="Like()">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                        </span>
                        <?php } ?>
                        <span class="read" data-book="<?= $book['book'] ?>"><i class="fab fa-readme"></i></span>
                    </div>
                    <button class="btn btn-success down-btn" data-book="<?= $book['book'] ?>"
                        data-id="<?= $book['id'] ?>" data-owner="<?= $book['owner_id'] ?>">Download</button>
                </div>
            </div>
        </main>
        <div id="the-canvas">

        </div>
        <div class="overlayy">
            <span class="close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </span>
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <?php require_once __DIR__ . '/includes/scripts.php' ?>
    </body>

</html>