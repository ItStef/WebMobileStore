<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\Device;
use app\models\Sale;

class CartController extends BaseController
{
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];
        $devices = [];
        $total = 0.0;
        if ($cart) {
            $ids = array_keys($cart);
            $devices = Device::findMany($ids);
            foreach ($devices as &$device) {
                $device['quantity'] = $cart[$device['id']];
                $device['subtotal'] = $device['price'] * $device['quantity'];
                $total += $device['subtotal'];
            }
        }
        $msg = "";
        if (isset($_GET['ordered'])) {
            $msg = "Order placed! Thank you.";
        }
        $this->render('cart/index', ['devices' => $devices, 'total' => $total, 'msg' => $msg]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
            $removeId = (int)$_POST['remove'];
            if (isset($_SESSION['cart'][$removeId])) {
                unset($_SESSION['cart'][$removeId]);
            }
            $this->redirect('cart');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_qty'])) {
            $addId = (int)$_POST['add_qty'];
            if (isset($_SESSION['cart'][$addId])) {
                $_SESSION['cart'][$addId]++;
            }
            $this->redirect('cart');
        }

        $cart = $_SESSION['cart'] ?? [];
        $devices = [];
        if ($cart) {
            $ids = array_keys($cart);
            $devices = Device::findMany($ids);
            foreach ($devices as &$device) {
                $device['quantity'] = $cart[$device['id']];
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order']) && $devices) {
            foreach ($devices as $device) {
                Sale::create($device['id'], $device['quantity']);
            }
            $_SESSION['cart'] = [];
            $this->redirect('cart', ['ordered' => 1]);
        }
    }
}