<?php
require_once __DIR__ . '/../src/Models/Database.php';
require_once __DIR__ . '/../src/request.php';
if (!(isset($_SESSION['email']))) {
    header('location: login.php');
    return;
}
$user = (new Database())->checkExist($_SESSION['email'])[0];
$categories = (new Database())->fetchCategory($user['id']);
// print_r($categories);
$num = 0;
?>
<!DOCTYPE html>
<html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <?php require_once __DIR__ . '/includes/styles.php' ?>

        <title>Manage Category</title>
    </head>

    <body class="dashboard">
        <?php require_once __DIR__ . '/includes/nav.php' ?>

        <main class="category">
            <div class="table-wrapper">
                <table id="cat-table" class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Category</th>
                            <th>Created On</th>
                            <th>Updated On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) {
                        $num++;
                    ?>
                        <tr>
                            <td><?= $num ?></td>
                            <td><?= $category['category'] ?></td>
                            <td><?= $category['created_on'] ?></td>
                            <td><?= $category['updated_on'] ?></td>
                            <td>
                                <button class="btn btn-primary edit" data-id="<?= $category['id'] ?>"
                                    data-bs-toggle="modal" data-bs-target="#editCategory">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-danger delete" data-id="<?= $category['id'] ?>"
                                    data-bs-toggle="modal" data-bs-target="#deleteCategory">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="editCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="editCategoryLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="modal-body" id="eCategory" method="post">
                            <div class="input">
                                <input type="text" name="category" id="editCategoryInp" placeholder="">
                                <label for="editCategoryInp">Category Name</label>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="eCategory" name="addCategory"
                                class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deleteCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="deleteCategoryLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteCategoryLabel">Delete Category?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <i class="fa fa-exclamation-triangle exc" aria-hidden="true"></i>
                            Are you sure you want to delete this category
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger confirm-delete">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once __DIR__ . '/includes/scripts.php' ?>
    </body>

</html>