<?php
require_once __DIR__ . '/Controllers/Admin.php';
require_once __DIR__ . '/Controllers/User.php';
require_once __DIR__ . '/Controllers/Category.php';
require_once __DIR__ . '/Controllers/Book.php';
require_once __DIR__ . '/Models/Database.php';
if (isset($_POST['register'])) {
    array_pop($_POST);
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $access = $_POST['access'];
    $res = (new Admin())->register($_POST);
    if (!empty($res)) {
        $err = $res['error'];
        return $err;
    }
} elseif (isset($_POST['login'])) {
    $email = $_POST['email'];
    array_pop($_POST);
    $res = (new Admin())->login($_POST);
    if (!empty($res)) {
        $err = $res['error'];
        return $err;
    }
} elseif (isset($_POST['update'])) {
    array_pop($_POST);
    $res = (new Admin())->update($_POST, $_SESSION['email']);
    if (isset($res['error'])) {
        $err = $res['error'];
        return $err;
    } else {
        $success = $res['success'];
        return $success;
    }
    print_r($res);
} elseif (isset($_POST['addCategory'])) {
    array_pop($_POST);
    $user = (new Database())->checkExist($_SESSION['email']);
    $res = (new Category())->add($_POST, $user[0]['id']);
    if (isset($res['error'])) {
        $err = $res['error'];
        return $err;
    } else {
        $success = $res['success'];
        return $success;
    }
    print_r($res);
} elseif (isset($_POST['category_id'])) {
    $cat = (new Database())->fetchCatDetails($_POST['category_id']);
    echo json_encode($cat);
} elseif (isset($_POST['book_id'])) {
    $book = (new Database())->fetchBookDetails($_POST['book_id']);
    echo json_encode($book);
} elseif (isset($_POST['new_category'])) {
    $update = (new Category())->update($_POST['id'], $_POST['new_category']);
    echo json_encode($update);
} elseif (isset($_POST['delete'])) {
    $delete = (new Category())->delete($_POST['delete']);
    echo json_encode($delete);
} elseif (isset($_POST['deleteBook'])) {
    $delete = (new Book())->delete($_POST['deleteBook']);
    echo json_encode($delete);
} elseif (isset($_POST['addBook'])) {
    array_pop($_POST);
    $name = $_POST['name'];
    $author = $_POST['author'];
    $image = $_FILES['cover'];
    $book = $_FILES['bookChooser'];
    // print_r($image);
    $user = (new Database())->checkExist($_SESSION['email']);
    $res = (new Book())->add($_POST, $user[0]['id'], $book, $image);
    if (isset($res['error'])) {
        $err = $res['error'];
        return $err;
    } else {
        $success = $res['success'];
        return $success;
    }
    print_r($res);
} elseif (isset($_POST['subEName'])) {
    $user = (new Database())->checkExist($_SESSION['email']);
    $res = (new Book())->update($_POST['id'], $_POST['eName'], $_POST['bookCategory']);
    if (isset($res['error'])) {
        $err = $res['error'];
        return $err;
    } else {
        header('location: ../../../admin/manage-book.php');
        $success = $res['success'];
        return $success;
    }
    print_r($res);
} elseif (isset($_POST['userRegister'])) {
    array_pop($_POST);
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $res = (new User())->register($_POST);
    if (!empty($res)) {
        $err = $res['error'];
        return $err;
    }
} elseif (isset($_POST['userLogin'])) {
    $email = $_POST['email'];
    array_pop($_POST);
    $res = (new User())->login($_POST);
    if (!empty($res)) {
        $err = $res['error'];
        return $err;
    }
} elseif (isset($_POST['owner_id'])) {
    $owner = (new Database())->checkIdExist($_POST['owner_id']);
    echo json_encode($owner);
} elseif (isset($_POST['limit'])) {
    $moreBooks = (new Database())->fetchMore($_POST['limit'], $_POST['offset']);
    if ($moreBooks) {
        echo json_encode($moreBooks);
    } else {
        echo json_encode("No More Books Found");
    }
} elseif (isset($_POST['viewed'])) {
    $view = (new Book())->view($_POST, $_SESSION['user_id']);
    echo json_encode($view);
} elseif (isset($_POST['like_id'])) {
    $view = (new Book())->like($_POST, $_SESSION['user_id']);
    echo json_encode($view);
} elseif (isset($_POST['download_id'])) {
    $view = (new Book())->download($_POST, $_SESSION['user_id']);
    echo json_encode($view);
} elseif (isset($_POST['check_id'])) {
    $res = "";
    $liked = (new Database())->checkLikedBook($_POST['check_id'], $_SESSION['user_id']);
    if ($liked) {
        $res = "Liked";
    } else {
        $res = "Unliked";
    }
    echo json_encode($res);
} elseif (isset($_POST['search'])) {
    $search = array();
    $book = (new Database())->fetchAllBooksWL();
    foreach ($book as $b) {
        if (strstr(strtolower($b['name']), strtolower($_POST['search']))) {
            array_push($search, $b);
        }
    }
    echo json_encode($search);
} elseif (isset($_POST['resetPassword'])) {
    array_pop($_POST);
    $curPassword = $_POST['password'];
    $newPassword = $_POST['newPassword'];
    $cPassword = $_POST['conpassword'];
    $res = (new Admin())->reset($_POST);
    if (isset($res['error'])) {
        $err = $res['error'];
        return $err;
    } else {
        $success = $res['success'];
        return $success;
    }
    print_r($res);
} elseif (isset($_POST['updateUser'])) {
    array_pop($_POST);
    $res = (new User())->update($_POST, $_SESSION['user_id']);
    if (isset($res['error'])) {
        $err = $res['error'];
        return $err;
    } else {
        $success = $res['success'];
        return $success;
    }
    print_r($res);
} elseif (isset($_POST['resetPass'])) {
    array_pop($_POST);
    $curPassword = $_POST['password'];
    $newPassword = $_POST['newPassword'];
    $cPassword = $_POST['conpassword'];
    $res = (new User())->reset($_POST);
    if (isset($res['error'])) {
        $errP = $res['error'];
        return $errP;
    } else {
        $successP = $res['success'];
        return $successP;
    }
    print_r($res);
}
