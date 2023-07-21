<?php
session_start();
require_once __DIR__ . './src/Models/Database.php';
if (!(isset($_SESSION['user_id']))) {
    header('location: login.php');
    return;
}
$user = (new Database())->checkUserIdExist($_SESSION['user_id'])[0];
$books = (new Database())->fetchAllBooks();
$books = array_reverse($books);
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php require_once __DIR__ . './includes/styles.php' ?>

    <title>Books</title>
</head>

<body id="books">
    <a href='./src/logout.php' class='logout'>
        <i class='fas fa-arrow-right-from-bracket'></i>
    </a>
    <main class='books-main'>
        <div class='greeting'>
            <h3><span class='good'>Good</span>
                <?= $user['username'] ?>
            </h3>
            <a href="./profile.php"><?= substr($user['username'], 0, 1) ?></a>
        </div>
        <div class="search">
            <div class="input" data-bs-toggle="modal" data-bs-target="#search">
                <input type="text" name="search" placeholder="">
                <label for="seacrhBook">Search For Books</label>
                <span class="search-icon">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </span>
            </div>
        </div>
        <div class="modal fade" id="search" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="searchLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchLabel">Search For Books</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input">
                            <input type="search" name="search" id="searchBookModal" placeholder="" list="booksInp">
                            <label for="searchBookModal">Type to start searching</label>
                            <span class="search-icon">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </span>
                            <datalist id="booksInp">

                            </datalist>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="books">
            <?php foreach ($books as $book) { ?>
                <div class="book-ju" data-id="<?= $book['id'] ?>" data-owner="<?= $book['owner_id'] ?>">
                    <div class="image">
                        <img src="./assets/images/<?= $book['cover'] ?>" alt="">
                    </div>
                    <div class="details">
                        <div class="top">
                            <span class="author"><?= $book['author'] ?></span>
                            <span class="book-category">
                                <?= (new Database())->fetchCatDetails($book['category_id'])[0]['category'] ?>
                            </span>
                        </div>
                        <div class="bottom">
                            <span class="title">
                                <?= $book['name'] ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <button class="btn btn-success mb-3" id="loadMore">Load More...</button>
    </main>
    <?php require_once __DIR__ . './includes/scripts.php' ?>
</body>

</html>