<?php

namespace app\models;

use app\core\DbConnection;

class User
{
    public static function findById($id)
    {
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function findByUsername($username)
    {
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function authenticate($username, $password)
    {
        $user = self::findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
        return false;
    }

    public static function register($username, $password)
    {
        if (!$username || !$password) {
            return "Username and password required.";
        }
        if (self::findByUsername($username)) {
            return "Username already exists.";
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        $stmt->bind_param("ss", $username, $hash);
        if ($stmt->execute()) {
            return true;
        }
        return "Registration failed.";
    }

    public static function updatePassword($id, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hash, $id);
        return $stmt->execute();
    }

    public static function all()
    {
        $conn = (new DbConnection())->connect();
        $result = $conn->query("SELECT id, username, role FROM users ORDER BY username");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}