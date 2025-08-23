<?php

namespace app\models;

use app\core\DbConnection;

class Sale
{
    public static function create($device_id, $quantity)
    {
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("INSERT INTO sales (device_id, quantity) VALUES (?, ?)");
        $stmt->bind_param("ii", $device_id, $quantity);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public static function all()
    {
        $conn = (new DbConnection())->connect();
        $result = $conn->query("SELECT * FROM sales");
        return $result->fetch_all(\MYSQLI_ASSOC);
    }
}