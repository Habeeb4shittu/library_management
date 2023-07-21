<?php
class Database
{
    protected $connection;
    public function __construct()
    {
        $this->connect();
    }
    public function connect()
    {
        try {

            $conn = new PDO('mysql:host=localhost;dbname=klemzxvb_readers', "klemzxvb_reader", "UC*y)S,T33(t");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = $conn;
        } catch (PDOException $err) {
            echo $err;
        }
    }
    public function getAccess()
    {
        try {
            $select = 'SELECT * FROM access';
            $stmt = $this->connection->prepare($select);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function insertAdmin($data)
    {
        try {
            $insert = 'INSERT INTO admin(firstname, lastname, email, username, password) VALUES(:firstname, :lastname, :email, :username, :password) ';
            $insert = $this->connection->prepare($insert);
            $insert->execute([
                ':firstname' => $data['firstname'],
                ':lastname' => $data['lastname'],
                ':email' => $data['email'],
                ':username' => $data['username'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ]);
            $insertUser = 'INSERT INTO user(firstname, lastname, email, username, password) VALUES(:firstname, :lastname, :email, :username, :password) ';
            $insertUser = $this->connection->prepare($insertUser);
            $insertUser->execute([
                ':firstname' => $data['firstname'],
                ':lastname' => $data['lastname'],
                ':email' => $data['email'],
                ':username' => $data['username'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ]);
            if ($insert && $insertUser) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkExist($data)
    {
        try {
            $query = 'SELECT * FROM admin WHERE email = :email';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':email' => $data,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkIdExist($data)
    {
        try {
            $query = 'SELECT * FROM admin WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $data,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkUserExist($data)
    {
        try {
            $query = 'SELECT * FROM user WHERE email = :email';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':email' => $data,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkUserIdExist($id)
    {
        try {
            $query = 'SELECT * FROM user WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkUserAdminExist($data)
    {
        try {
            $query = 'SELECT * FROM admin WHERE email = :email';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':email' => $data,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkAdminUserName($data)
    {
        try {
            $query = 'SELECT * FROM admin WHERE username = :username';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':username' => $data,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkUserName($data)
    {
        try {
            $query = 'SELECT * FROM user WHERE username = :username';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':username' => $data,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function updateAdmin($data, $email)
    {
        try {
            $query = 'UPDATE admin SET firstname = :firstname, lastname = :lastname, username = :username, email = :email, updated_on = DEFAULT WHERE email = :curemail';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':firstname' => $data['firstname'],
                ':lastname' => $data['lastname'],
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':curemail' => $email,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function updateUser($data, $id)
    {
        try {
            $query = 'UPDATE user SET firstname = :firstname, lastname = :lastname, username = :username, email = :email, updated_on = DEFAULT WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':firstname' => $data['firstname'],
                ':lastname' => $data['lastname'],
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':id' => $id,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function resetPassword($data, $email)
    {
        try {
            $query = 'UPDATE admin SET password = :password, updated_on = DEFAULT WHERE email = :curemail';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':password' => password_hash($data['newPassword'], PASSWORD_DEFAULT),
                ':curemail' => $email,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function resetUserPassword($data, $id)
    {
        try {
            $query = 'UPDATE user SET password = :password, updated_on = DEFAULT WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':password' => password_hash($data['newPassword'], PASSWORD_DEFAULT),
                ':id' => $id,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkCategory($category, $id)
    {
        try {
            $query = 'SELECT * FROM category WHERE owner_id = :owner_id AND category = :category';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':owner_id' => $id,
                ':category' => $category,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function fetchCategory($id)
    {
        try {
            $query = 'SELECT * FROM category WHERE owner_id = :owner_id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':owner_id' => $id,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function fetchBook($id)
    {
        try {
            $select = 'SELECT COUNT(*) FROM likes WHERE book_id = :book_id';
            $sel = $this->connection->prepare($select);
            $sel->execute([
                ":book_id" => $id
            ]);
            $res = $sel->fetch(PDO::FETCH_COLUMN);
            $insert = 'UPDATE book SET likes = :likes';
            $up = $this->connection->prepare($insert);
            $up->execute([
                ":likes" => $res
            ]);
            $query = 'SELECT * FROM book WHERE owner_id = :owner_id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':owner_id' => $id,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function fetchAllBooks()
    {
        try {
            $query = 'SELECT * FROM book LIMIT 10';
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function fetchAllBooksWL()
    {
        try {

            $query = 'SELECT * FROM book';
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function fetchCatDetails($id)
    {
        try {
            $query = 'SELECT * FROM category WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function fetchBookDetails($id)
    {
        try {
            $select = 'SELECT COUNT(*) FROM likes WHERE book_id = :book_id';
            $sel = $this->connection->prepare($select);
            $sel->execute([
                ":book_id" => $id
            ]);
            $res = $sel->fetch(PDO::FETCH_COLUMN);
            $insert = 'UPDATE book SET likes = :likes';
            $up = $this->connection->prepare($insert);
            $up->execute([
                ":likes" => $res
            ]);
            $query = 'SELECT * FROM book WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function fetchCat($id)
    {
        try {
            $query = 'SELECT * FROM category WHERE owner_id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function updateCategory($id, $category)
    {
        try {
            $query = 'UPDATE category SET category = :category, updated_on = DEFAULT WHERE id = :id';
            $update = $this->connection->prepare($query);
            $update->execute([
                ':category' => $category,
                ':id' => $id,
            ]);
            if ($update) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function updateBook($id, $bookName, $category_id)
    {
        try {
            $query = 'UPDATE book SET name = :bookName, category_id = :category_id,  modified_on = DEFAULT WHERE id = :id';
            $update = $this->connection->prepare($query);
            $update->execute([
                ':bookName' => $bookName,
                ':category_id' => $category_id,
                ':id' => $id,
            ]);
            if ($update) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function addCategory($data, $id)
    {
        try {
            $query = 'INSERT INTO category(category, owner_id) VALUES(:category, :owner_id)';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':category' => $data['category'],
                ':owner_id' => $id,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function deleteCategory($id)
    {
        try {
            $query = 'DELETE FROM category WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function deleteBook($id)
    {
        try {
            $query = 'DELETE FROM book WHERE id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function countCategory($id)
    {
        try {
            $query = 'SELECT COUNT(*) FROM category WHERE owner_id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function countViews($id)
    {
        try {
            $query = 'SELECT COUNT(*) FROM views WHERE owner_id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function countLikes($id)
    {
        try {
            $query = 'SELECT COUNT(*) FROM likes WHERE owner_id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function countDownloads($id)
    {
        try {
            $query = 'SELECT COUNT(*) FROM downloads WHERE owner_id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function countBookViews($id)
    {
        try {
            $query = 'SELECT COUNT(*) FROM views WHERE book_id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function countBookLikes($id)
    {
        try {
            $query = 'SELECT COUNT(*) FROM likes WHERE book_id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function countBook($id)
    {
        try {
            $query = 'SELECT COUNT(*) FROM book WHERE owner_id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':id' => $id,
            ]);
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkBook($book, $id)
    {
        try {
            $query = 'SELECT * FROM book WHERE owner_id = :owner_id AND name = :book';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':owner_id' => $id,
                ':book' => $book,
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function addBook($book, $id, $bookFile, $cover)
    {
        try {
            $query = 'INSERT INTO book(name, book, category_id,cover, author, owner_id) VALUES(:name,:book, :category_id, :cover, :author, :owner_id)';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':name' => $book['name'],
                ':book' => $bookFile,
                ':category_id' => $book['bookCategory'],
                ':cover' => $cover,
                ':author' => $book['author'],
                ':owner_id' => $id,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function createUser($data)
    {
        try {
            $insert = 'INSERT INTO user(firstname, lastname, email, username, password) VALUES(:firstname, :lastname, :email, :username, :password) ';
            $insert = $this->connection->prepare($insert);
            $insert->execute([
                ':firstname' => $data['firstname'],
                ':lastname' => $data['lastname'],
                ':email' => $data['email'],
                ':username' => $data['username'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ]);
            if ($insert) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function addFav($bookId, $owner, $status)
    {
        try {
            $check = 'SELECT * FROM favourites WHERE book_id = :book_id AND fav_owner = :owner_id';
            $checked = $this->connection->prepare($check);
            $checked->execute([
                ':book_id' => $bookId,
                ':owner_id' => $owner,
            ]);
            $result = $checked->fetchAll(PDO::FETCH_ASSOC);
            // return $result;
            if ($result) {
                $insert = 'UPDATE favourites SET status = :status';
                $insert = $this->connection->prepare($insert);
                $insert->execute([
                    ':status' => $status,
                ]);
                if ($insert) {
                    return $status;
                }
            } else {
                $insert = 'INSERT INTO favourites(book_id, fav_owner, status) VALUES(:book_id,:owner_id, :status) ';
                $insert = $this->connection->prepare($insert);
                $insert->execute([
                    ':book_id' => $bookId,
                    ':owner_id' => $owner,
                    ':status' => $status,
                ]);
                if ($insert) {
                    return $status;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function fetchMore($bookLimit, $offset)
    {
        try {
            $query = "SELECT * FROM book LIMIT $offset, $bookLimit";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function viewBook($viewed, $owner, $id)
    {
        try {
            $check = 'SELECT * FROM views WHERE book_id = :book_id AND user_id = :user_id';
            $checked = $this->connection->prepare($check);
            $checked->execute([
                ':book_id' => $viewed,
                ':user_id' => $id,
            ]);
            $result = $checked->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return "Viewed";
            }
            $query = 'INSERT INTO views(book_id, user_id, owner_id) VALUES(:book_id,:user_id, :owner_id)';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':book_id' => $viewed,
                ':user_id' => $id,
                ':owner_id' => $owner,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function likeBook($viewed, $owner, $id)
    {
        try {
            $check = 'SELECT * FROM likes WHERE book_id = :book_id AND user_id = :user_id';
            $checked = $this->connection->prepare($check);
            $checked->execute([
                ':book_id' => $viewed,
                ':user_id' => $id,
            ]);
            $result = $checked->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                $query = 'DELETE FROM likes WHERE book_id = :book_id AND user_id = :user_id';
                $stmt = $this->connection->prepare($query);
                $stmt->execute([
                    ':book_id' => $viewed,
                    ':user_id' => $id,
                ]);
                if ($stmt) {
                    return "Unliked";
                }
            }
            $query = 'INSERT INTO likes(book_id, user_id, owner_id) VALUES(:book_id,:user_id, :owner_id)';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':book_id' => $viewed,
                ':user_id' => $id,
                ':owner_id' => $owner,
            ]);
            if ($stmt) {
                return "Liked";
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function downloadBook($viewed, $owner, $id)
    {
        try {
            $check = 'SELECT * FROM downloads WHERE book_id = :book_id AND user_id = :user_id';
            $checked = $this->connection->prepare($check);
            $checked->execute([
                ':book_id' => $viewed,
                ':user_id' => $id,
            ]);
            $result = $checked->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return "Downloaded";
            }
            $query = 'INSERT INTO downloads(book_id, user_id, owner_id) VALUES(:book_id,:user_id, :owner_id)';
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':book_id' => $viewed,
                ':user_id' => $id,
                ':owner_id' => $owner,
            ]);
            if ($stmt) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    public function checkLikedBook($viewed, $id)
    {
        $check = 'SELECT * FROM likes WHERE book_id = :book_id AND user_id = :user_id';
        $checked = $this->connection->prepare($check);
        $checked->execute([
            ':book_id' => $viewed,
            ':user_id' => $id,
        ]);
        $result = $checked->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function fetchLiked($id)
    {
        $check = 'SELECT * FROM likes WHERE user_id = :user_id';
        $checked = $this->connection->prepare($check);
        $checked->execute([
            ':user_id' => $id,
        ]);
        $result = $checked->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}