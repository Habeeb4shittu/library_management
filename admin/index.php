<?php
session_start();
require_once __DIR__ . '/../src/Models/Database.php';
if (!(isset($_SESSION['email']))) {
    header('location: login.php');
    return;
}
$user = (new Database())->checkExist($_SESSION['email'])[0];
$categoryCount = (new Database())->countCategory($user['id']);
$viewCount = (new Database())->countViews($user['id']);
$bookCount = (new Database())->countBook($user['id']);
$likeCount = (new Database())->countLikes($user['id']);
$downloadCount = (new Database())->countDownloads($user['id']);
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php require_once __DIR__ . '/includes/styles.php' ?>

    <title>Admin Dashboard</title>
</head>

<body class='dashboard'>
    <?php require_once __DIR__ . '/includes/nav.php' ?>
    <a href='./src/logout.php' class='logout'>
        <i class='fas fa-arrow-right-from-bracket'></i>
    </a>
    <main id='dash'>
        <div class='greeting'>
            <h3><span class='good-d'>Good</span>
                <?= $user['username'] ?>
            </h3>
        </div>
        <div class='cards'>
            <div class='card book-card'>
                <h2 class='name'>Published Books</h2>
                <span class='count book-count'>
                    <?= $bookCount ?>
                </span>
            </div>
            <div class='card category-card'>
                <h2 class='name'>Categories</h2>
                <span class='count category-count'>
                    <?= $categoryCount ?>
                </span>
            </div>
            <div class='card'>
                <h2 class='name'>Views</h2>
                <span class='count view-count'>
                    <?= $viewCount ?>
                </span>
            </div>
            <div class='card'>
                <h2 class='name'>Likes</h2>
                <span class='count like-count'>
                    <?= $likeCount ?>
                </span>
            </div>
            <div class='card'>
                <h2 class='name'>Downloads</h2>
                <span class='count download-count'>
                    <?= $downloadCount ?>
                </span>
            </div>
        </div>
        <div id="chart"></div>
    </main>
    <?php require_once __DIR__ . '/includes/scripts.php' ?>
</body>

</html>