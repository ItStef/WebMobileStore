<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Auth;
use app\models\Device;

class DeviceController extends BaseController
{
    public function index()
    {
        $devices = Device::all();
        $this->render('devices/index', ['devices' => $devices]);
    }

    public function add()
    {
        Auth::requireAdmin();
        $msg = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $brand = trim($_POST['brand'] ?? '');
            $os = trim($_POST['os'] ?? '');
            $year = intval($_POST['year'] ?? 0);
            $price = floatval($_POST['price'] ?? 0);
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['png','jpg','jpeg','gif'])) {
                    $filename = uniqid('img_') . '.' . $ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../public/images/$filename");
                    $image = $filename;
                }
            }
            Device::add($name, $brand, $os, $year, $price, $image);
            $msg = "Device added!";
        }
        $this->render('devices/add', ['msg' => $msg]);
    }
}