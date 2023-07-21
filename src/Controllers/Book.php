<?php
require_once __DIR__ . '/../Models/Database.php';
class Book
{
    public function add($book, $id, $bookFile, $cover)
    {
        $res = [];
        $empty = 0;
        $cat = '';
        $coverTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $imageFolder = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/' . $cover['name'];
        $bookFolder = $_SERVER['DOCUMENT_ROOT'] . '/assets/books/' . $bookFile['name'];
        $check = (new Database())->checkBook($book['name'], $id);
        foreach ($book as $detail) {
            if (empty($detail)) {
                $empty++;
            }
        }
        if ($empty > 0) {
            $res['error'] = "Input Fields cant be empty";
        } elseif ($check) {
            $res['error'] = "Book Already Exists";
        } elseif (!in_array($cover['type'], $coverTypes)) {
            $res['error'] = "Invalid book cover type";
        } elseif ($bookFile['type'] !== 'application/pdf') {
            $res['error'] = "Invalid book type";
        } else {
            if (move_uploaded_file($cover['tmp_name'], $imageFolder) && move_uploaded_file($bookFile['tmp_name'], $bookFolder)) {
                $cat = (new Database())->addBook($book, $id, $bookFile['name'], $cover['name']);
                if ($cat) {
                    $res['success'] = "Book Successfully Added";
                }
            } else {
                $res['error'] = "Error Uploading Files";
            }
        }
        return $res;
    }
    public function update($id, $bookName, $category_id)
    {
        $res = [];
        $empty = 0;
        $cat = '';
        if (empty($category_id) || empty($bookName)) {
            $empty++;
        }
        if ($empty > 0) {
            $res['error'] = "Input Fields cant be empty";
        } else {
            $cat = (new Database())->updateBook($id, $bookName, $category_id);
            if ($cat) {
                $res['success'] = "Book Successfully Saved";
            }
        }
        return $res;
    }
    public function delete($id)
    {
        $res = (new Database())->deleteBook($id);
        return $res;
    }
    public function fav($bookId, $ownerId, $status)
    {
        $res = (new Database())->addFav($bookId, $ownerId, $status);
        return $res;
    }
    public function view($data, $id)
    {
        $res = (new Database())->viewBook($data['viewed'], $data['owner'], $id);
        return $res;
    }
    public function like($data, $id)
    {
        $res = (new Database())->likeBook($data['like_id'], $data['owner_like_id'], $id);
        return $res;
    }
    public function download($data, $id)
    {
        $res = (new Database())->downloadBook($data['download_id'], $data['owner_download_id'], $id);
        return $res;
    }
}
