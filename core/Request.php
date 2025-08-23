<?php

namespace app\core;

class Request
{
    public static function input($name, $default = null)
    {
        return $_POST[$name] ?? $_GET[$name] ?? $default;
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public static function file($name)
    {
        return $_FILES[$name] ?? null;
    }
}