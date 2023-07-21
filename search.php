<?php
session_start();
require_once __DIR__ . './src/Models/Database.php';
if (!(isset($_SESSION['user_id']))) {
    header('location: login.php');
    return;
} elseif (!(isset($_GET['search']))) {
    header('location: books.php');
    return;
}
$user = (new Database())->checkUserIdExist($_SESSION['user_id'])[0];
$books = (new Database())->fetchAllBooksWL();
$contain = array();
foreach ($books as $book) {
    if (strpos(strtolower($book['name']), strtolower($_GET['search'])) !== false) {
        array_push($contain, $book);
    }
}
?>
<!DOCTYPE html>
<html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <?php require_once __DIR__ . './includes/styles.php' ?>

        <title>Search Results For <?= $_GET['search'] ?></title>
    </head>

    <body class="d-flex flex-column gap-5">
        <input type="hidden" value="<?= $_GET['search'] ?>" class="search">
        <main class='books-main mt-4'>
            <?php if (!$contain) { ?>
            <h2 class="text-danger text-center text-lg-center">No results Found for <mark><?= $_GET['search'] ?></mark>
            </h2>
            <div class="container d-flex align-items-center justify-content-center">
                <a href="./books.php">Go back</a>
            </div>
            <?php } else { ?>
            <h2 class="text-danger text-center">Search Results for <mark><?= $_GET['search'] ?></mark></h2>
            <div class="books">
                <?php foreach ($contain as $book) { ?>
                <div class="book-ju searched" data-id="<?= $book['id'] ?>" data-owner="<?= $book['owner_id'] ?>">
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
            <?php } ?>
        </main>
        <?php require_once __DIR__ . './includes/scripts.php' ?>
        <script>
        let search = $(".search").val()
        $(".searched").each(function(i, el) {
            let word = $(el).find(".title").text().trim()
            let index = word.toLowerCase().indexOf(search.toLowerCase())
            if (i >= 0) {
                let bt = word.substring(0, index)
                let hi = word.substring(index, index + search.length)
                let at = word.substring(index + search.length)

                $(el).find(".title").html(`${bt}<span class="bg-secondary text-light">${hi}</span>${at}`)
            }
        })
        </script>

    </body>

</html>