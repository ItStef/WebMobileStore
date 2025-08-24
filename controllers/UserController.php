<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Auth;
use app\models\User;

class UserController extends BaseController
{
    public function profile()
    {
        Auth::requireLogin();
        $user = User::findById($_SESSION['user']['id']);
        $this->render('users/profile', ['user' => $user]);
    }

    public function edit()
    {
        Auth::requireLogin();
        $user = User::findById($_SESSION['user']['id']);
        $msg = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            if ($password) {
                if (User::updatePassword($user['id'], $password)) {
                    $msg = "Password updated.";
                } else {
                    $msg = "Update failed.";
                }
            }
        }
        $this->render('users/edit', ['user' => $user, 'msg' => $msg]);
    }

    public function list()
    {
        Auth::requireAdmin();
        $users = User::all();
        $this->render('users/list', ['users' => $users]);
    }
}