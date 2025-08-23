<?php

namespace app\core;

use mysqli;

class DbConnection
{
    public function connect()
    {
        $mysqli = new mysqli("localhost", "root", "root", "vbis_mobilestore");
        if ($mysqli->connect_error) {
            die("Database connection failed: " . $mysqli->connect_error);
        }
        $mysqli->set_charset("utf8mb4");
        return $mysqli;
    }
}