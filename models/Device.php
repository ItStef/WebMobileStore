<?php

namespace app\models;

use app\core\DbConnection;
use mysqli_sql_exception;

class Device
{
    public static function all()
    {
        $conn = (new DbConnection())->connect();
        $result = $conn->query("SELECT * FROM devices ORDER BY name");
        return $result->fetch_all(\MYSQLI_ASSOC);
    }

    public static function find($id)
    {
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("SELECT * FROM devices WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function findMany($ids)
    {
        if (!$ids) return [];
        $conn = (new DbConnection())->connect();
        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $conn->prepare("SELECT * FROM devices WHERE id IN ($in)");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(\MYSQLI_ASSOC);
    }

    public static function add($name, $brand, $os, $year, $price, $image)
    {
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("INSERT INTO devices (name, brand, os, year, price, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssids", $name, $brand, $os, $year, $price, $image);
        $stmt->execute();
        return $stmt->insert_id;
    }
        public static function updatePrice($id, $new_price)
    {
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("UPDATE devices SET price = ? WHERE id = ?");
        $stmt->bind_param("di", $new_price, $id);
        $stmt->execute();
    }

    public static function delete($id)
    {
        $conn = (new DbConnection())->connect();
        $stmt = $conn->prepare("DELETE FROM devices WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    
    public static function import($file)
    {
        $conn = (new DbConnection())->connect();
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $count = 0;

        if ($ext === 'json') {
            $content = file_get_contents($file['tmp_name']);
            $devices = json_decode($content, true);
            if (!is_array($devices)) return "Invalid JSON file.";
            foreach ($devices as $d) {
                $stmt = $conn->prepare("INSERT INTO devices (name, brand, os, year, price, image) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssids", $d['name'], $d['brand'], $d['os'], $d['year'], $d['price'], $d['image']);
                try { $stmt->execute(); $count++; } catch (mysqli_sql_exception $e) {}
            }
            return "Imported $count devices from JSON.";
        } elseif ($ext === 'xml') {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_file($file['tmp_name']);
            if ($xml === false) return "Invalid XML file.";
            foreach ($xml->device as $d) {
                $name = (string)$d->name;
                $brand = (string)$d->brand;
                $os = (string)$d->os;
                $year = (int)$d->year;
                $price = (float)$d->price;
                $image = (string)$d->image;
                $stmt = $conn->prepare("INSERT INTO devices (name, brand, os, year, price, image) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssids", $name, $brand, $os, $year, $price, $image);
                try { $stmt->execute(); $count++; } catch (mysqli_sql_exception $e) {}
            }
            return "Imported $count devices from XML.";
        }
        return "Unsupported file type.";
    }

    public static function export($type)
    {
        $conn = (new DbConnection())->connect();
        $result = $conn->query("SELECT * FROM devices");
        if ($type === 'xml') {
            header('Content-Type: text/xml; charset=utf-8');
            header('Content-Disposition: attachment; filename="devices.xml"');
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<devices>\n";
            while ($row = $result->fetch_assoc()) {
                echo "  <device>\n";
                foreach ($row as $k => $v) {
                    echo "    <$k>" . htmlspecialchars($v) . "</$k>\n";
                }
                echo "  </device>\n";
            }
            echo "</devices>\n";
        } else {
            header('Content-Type: application/json; charset=utf-8');
            header('Content-Disposition: attachment; filename="devices.json"');
            $devices = [];
            while ($row = $result->fetch_assoc()) {
                $devices[] = $row;
            }
            echo json_encode($devices, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    public static function osStats()
    {
        $conn = (new DbConnection())->connect();
        $result = $conn->query("SELECT os, COUNT(*) as count FROM devices GROUP BY os");
        $labels = []; $counts = [];
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['os'];
            $counts[] = (int)$row['count'];
        }
        return ['labels' => $labels, 'counts' => $counts];
    }

    public static function soldStats()
    {
        $conn = (new DbConnection())->connect();
        $result = $conn->query("
            SELECT d.name, COALESCE(SUM(s.quantity),0) as sold
            FROM devices d
            LEFT JOIN sales s ON d.id = s.device_id
            GROUP BY d.id, d.name
            ORDER BY d.name
        ");
        $labels = []; $counts = [];
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['name'];
            $counts[] = (int)$row['sold'];
        }
        return ['labels' => $labels, 'counts' => $counts];
    }

    
}