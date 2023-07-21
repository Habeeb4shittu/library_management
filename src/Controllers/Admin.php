<?php
require_once __DIR__ . '/../Models/Database.php';
session_start();

class Admin
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
        // $access = (new Database())->getAccess();
        if ($empty > 0) {
            $res['error'] = 'Input Fields cant be empty';
        } elseif (strlen($details['username']) < 3) {
            $res['error'] = 'Username cant be less than three characters';
        } elseif (strlen($details['password']) < 8) {
            $res['error'] = 'Password must contain 8 or more characters';
        } elseif ($details['password'] !== $details['conPassword']) {
            $res['error'] = 'Password Mismatch';
        } 
        // elseif ($details['access'] != $access[0]['code']) {
        //     $res['error'] = 'Incorrect access code';
        // }
         elseif ((new Database())->checkExist($details['email'])) {
            $res['error'] = 'Email already exists';
        } elseif (
            (new Database())->checkAdminUserName($details['username'])
        ) {
            $res['error'] = 'Username already exists';
        } else {
            $insert = (new Database())->insertAdmin($details);
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
            $user = (new Database())->checkExist($details['email']);
            if (empty($user)) {
                $res['error'] = 'Email does not exist';
            } else {
                if (password_verify($details['password'], $user[0]['password'])) {
                    $_SESSION['email'] = $user[0]['email'];
                    header('location: /admin/');
                } else {
                    $res['error'] = 'Incorrect Password';
                }
            }
        }
        return $res;
    }

    public function update($details, $email)
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
            $user = (new Database())->updateAdmin($details, $email);
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
        $data = (new Database())->checkExist($_SESSION['email']);
        if ($empty > 0) {
            $res['error'] = 'Input Fields cant be empty';
        } elseif (!(password_verify($details['password'], $data[0]['password']))) {
            $res['error'] = 'Incorrect Password';
        } elseif (strlen($details['newPassword']) < 8) {
            $res['error'] = 'Password must contain 8 or more characters';
        } elseif ($details['newPassword'] !== $details['conpassword']) {
            $res['error'] = 'Password Mismatch';
        } else {
            $insert = (new Database())->resetPassword($details, $_SESSION['email']);
            if ($insert) {
                $res['success'] = 'Details Updated Successfully';
            }
        }
        return $res;
    }
}