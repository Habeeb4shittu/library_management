<?php
require_once __DIR__ . '/../Models/Database.php';

class User
{
    public function register($details)
    {
        $res = [];
        $empty = 0;
        foreach ($details as $detail) {
            if (empty($detail)) {
                $empty++;
            }
        }
        if ($empty > 0) {
            $res['error'] = 'Input Fields cant be empty';
        } elseif (strlen($details['username']) < 3) {
            $res['error'] = 'Username cant be less than three characters';
        } elseif (strlen($details['password']) < 8) {
            $res['error'] = 'Password must contain 8 or more characters';
        } elseif (
            $details['password']
            !== $details['conPassword']
        ) {
            $res['error'] = 'Password Mismatch';
        } elseif ((new
            Database())->checkUserExist($details['email'])) {
            $res['error'] = 'Email already exists';
        } elseif ((new
            Database())->checkUserAdminExist($details['email'])) {
            $res['error'] = 'Email already exists';
        } elseif (
            (new Database())->checkUserName($details['username'])
        ) {
            $res['error'] = 'Username already exists';
        } else {
            $insert = (new Database())->createUser($details);
            if ($insert) {
                header('location: login.php');
            }
        }
        return $res;
    }
    public function login($details)
    {
        $res = [];
        $empty = 0;
        $user = '';
        foreach ($details as $detail) {
            if (empty($detail)) {
                $empty++;
            }
        }
        if ($empty > 0) {
            $res['error'] = 'Input Fields cant be empty';
        } else {
            $user = (new Database())->checkUserExist($details['email']);
            if (empty($user)) {
                $res['error'] = 'Email does not exist';
            } else {
                if (password_verify($details['password'], $user[0]['password'])) {
                    $_SESSION['user_id'] = $user[0]['id'];
                    header('location: books.php');
                } else {
                    $res['error'] = 'Incorrect Password';
                }
            }
        }
        return $res;
    }
    public function update($details, $id)
    {
        $res = [];
        $empty = 0;
        $user = '';
        foreach ($details as $detail) {
            if (empty($detail)) {
                $empty++;
            }
        }
        if ($empty > 0) {
            $res['error'] = 'Input Fields cant be empty';
        } else {
            $user = (new Database())->updateUser($details, $id);
            if ($user) {
                $res['success'] = 'Details Updated Successfully';
            }
        }
        return $res;
    }
    public function reset($details)
    {
        $res = [];
        $empty = 0;
        foreach ($details as $detail) {
            if (empty($detail)) {
                $empty++;
            }
        }
        $data = (new Database())->checkUserIdExist($_SESSION['user_id']);
        if ($empty > 0) {
            $res['error'] = 'Input Fields cant be empty';
        } elseif (!(password_verify($details['password'], $data[0]['password']))) {
            $res['error'] = 'Incorrect Password';
        } elseif (strlen($details['newPassword']) < 8) {
            $res['error'] = 'Password must contain 8 or more characters';
        } elseif ($details['newPassword'] !== $details['conpassword']) {
            $res['error'] = 'Password Mismatch';
        } else {
            $insert = (new Database())->resetUserPassword($details, $_SESSION['user_id']);
            if ($insert) {
                $res['success'] = 'Details Updated Successfully';
            }
        }
        return $res;
    }
}