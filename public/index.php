<?php
session_start();

    spl_autoload_register(function ($class) {
        $prefix = 'app\\';
        $base_dir = __DIR__ . '/../';

        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }
        $relative_class = substr($class, $len);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    });

    $page = $_GET['page'] ?? 'dashboard';
    $action = $_GET['action'] ?? 'index';

    if ($page === 'charts') {
        $controller = new \app\controllers\ChartsController();
        $chart = $_GET['chart'] ?? '';
        if (method_exists($controller, $chart)) {
            $controller->$chart();
            exit;
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Chart not found']);
            exit;
        }
    }

    switch ($page) {
        case 'devices':
            $controller = new \app\controllers\DeviceController();
            if ($action === 'add') {
                $controller->add();
            } elseif ($action === 'edit_price') {
                $controller->edit_price();
            } elseif ($action === 'delete') {
                $controller->delete();
            } else {
                $controller->index();
            }
            break;
        case 'charts':
            $controller = new \app\controllers\ChartsController();
            if ($action === 'osPie') {
                $controller->osPie();
            } elseif ($action === 'soldBar') {
                $controller->soldBar();
            } elseif ($action === 'brandDoughnut') {
                $controller->brandDoughnut();
            }
            break;
        case 'cart':
            $controller = new \app\controllers\CartController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->update();
            } else {
                $controller->index();
            }
            break;
        case 'admin':
            $controller = new \app\controllers\AdminController();
            $controller->index();
            break;
        case 'login':
            $controller = new \app\controllers\AuthController();
            $controller->login();
            break;
        case 'register':
            $controller = new \app\controllers\AuthController();
            $controller->register();
            break;
        case 'logout':
            $controller = new \app\controllers\AuthController();
            $controller->logout();
            break;
        case 'user':
            $controller = new \app\controllers\UserController();
            if ($action === 'edit') {
                $controller->edit();
            } elseif ($action === 'list') {
                $controller->list();
            } else {
                $controller->profile();
            }
            break;
        case 'dashboard':
            $controller = new \app\controllers\DashboardController();
            $controller->index();
            break;
        default:
            http_response_code(404);
            include __DIR__ . '/404.php';
            exit;
    }
?>