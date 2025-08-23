<?php

namespace app\core;

class Auth
{
    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
        return isset($_SESSION['user']);
    }

    public static function isAdmin()
    {
        return (isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? null) === 'admin');
    }

    public static function requireLogin()
    {
        if (!self::check()) {
            header("Location: /index.php?page=login");
            exit;
        }
    }

    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            header("Location: /index.php?page=login");
            exit;
        }
    }
}