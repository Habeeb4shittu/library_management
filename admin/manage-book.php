<?php
require_once __DIR__ . '/../src/Models/Database.php';
require_once __DIR__ . '/../src/request.php';
if (!(isset($_SESSION['email']))) {
    header('location: login.php');
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
    <?php require_once __DIR__ . './includes/styles.php' ?>

    <title>Manage Book</title>
</head>

<body class="dashboard">
    <?php require_once __DIR__ . './includes/nav.php' ?>

    <main class="category">
        <div class="table-wrapper">
            <table id="cat-table" class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Book Cover</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Views</th>
                        <th>Likes</th>
                        <th>Book Category</th>
                        <th>Updated On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book) {
                        $num++;
                    ?>
                        <tr>
                            <td><?= $num ?></td>
                            <td><img src="../assets/images/<?= $book['cover'] ?>" alt="" class="cover"></td>
                            <td><?= $book['name'] ?></td>
                            <td><?= $book['author'] ?></td>
                            <td>
                                <?= (new Database())->countBookViews($book['id']) ?>

                            </td>
                            <td>
                                <?= (new Database())->countBookLikes($book['id']) ?>

                            </td>
                            <td>
                                <?= (new Database())->fetchCatDetails($book['category_id'])[0]['category'] ?>

                            </td>
                            <td><?= $book['modified_on'] ?></td>
                            <td>
                                <a href="./manage-a-book.php?bookName=<?= $book['name'] ?>&bookCategory=<?= $book['category_id'] ?>&id=<?= $book['id'] ?>" class="btn btn-primary edit-book" data-id="<?= $book['id'] ?>">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>
                                <button class="btn btn-danger book-delete" data-id="<?= $book['id'] ?>" data-bs-toggle="modal" data-bs-target="#deleteBook">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="deleteBook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteBookLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBookLabel">Delete Book?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <i class="fa fa-exclamation-triangle exc" aria-hidden="true"></i>
                        Are you sure you want to delete this book
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger confirm-book-delete">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once __DIR__ . './includes/scripts.php' ?>
</body>

</html>