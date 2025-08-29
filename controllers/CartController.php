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
            $ids = array_unique($ids); // Fix: osigurava da nema duplikata
            $devices = Device::findMany($ids);
            foreach ($devices as &$device) {
                $device['quantity'] = $cart[$device['id']];
                $device['subtotal'] = $device['price'] * $device['quantity'];
                $total += $device['subtotal'];
            }
        }

        $msg = isset($_GET['ordered']) ? "Order placed! Thank you." : "";
        $this->render('cart/index', ['devices' => $devices, 'total' => $total, 'msg' => $msg]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['remove'])) {
                unset($_SESSION['cart'][(int)$_POST['remove']]);
            }
            if (isset($_POST['add_qty'])) {
                $id = (int)$_POST['add_qty'];
                if (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]++;
            }
            if (isset($_POST['sub_qty'])) {
                $id = (int)$_POST['sub_qty'];
                if (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id] > 1) {
                    $_SESSION['cart'][$id]--;
                } else {
                    unset($_SESSION['cart'][$id]);
                }
            }
            // Order
            if (isset($_POST['order']) && !empty($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
                $ids = array_keys($cart);
                $ids = array_unique($ids); 
                $devices = Device::findMany($ids);
                foreach ($devices as $device) {
                    Sale::create($device['id'], $cart[$device['id']]);
                }
                $_SESSION['cart'] = [];
                $this->redirect('cart', ['ordered' => 1]);
            }
            $this->redirect('cart');
        }
    }
}