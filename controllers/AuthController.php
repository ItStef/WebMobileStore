<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\User;

class AuthController extends BaseController
{
    public function login()
    {
        $msg = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = User::authenticate($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                $this->redirect('dashboard');
            } else {
                $msg = "Invalid username or password.";
            }
        }
        $this->render('auth/login', ['msg' => $msg]);
    }

    public function register()
    {
        $msg = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $result = User::register($username, $password);
            if ($result === true) {
                $this->redirect('login', ['registered' => 1]);
            } else {
                $msg = $result;
            }
        }
        $this->render('auth/register', ['msg' => $msg]);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('login');
    }
}