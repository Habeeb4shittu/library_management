<?php
require_once __DIR__ . '/../src/Models/Database.php';
require_once __DIR__ . '/../src/request.php';
if (!(isset($_SESSION['email']))) {
    header('location: login.php');
    return;
}
$user = (new Database())->checkExist($_SESSION['email'])[0];
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php require_once __DIR__ . '/includes/styles.php' ?>

    <title>New Category</title>
</head>

<body class="dashboard">
    <?php require_once __DIR__ . '/includes/nav.php' ?>

    <main class="category">
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
        <form method="post" id="nCategory">
            <div class="input">
                <input type="text" name="category" id="category" placeholder="" value="<?= isset($category) ? $category : '' ?>">
                <label for="category">Category Name</label>
            </div>
            <input type="submit" value="Add" form="nCategory" name="addCategory">
        </form>
    </main>
    <?php require_once __DIR__ . '/includes/scripts.php' ?>
</body>

</html>