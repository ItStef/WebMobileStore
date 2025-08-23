<?php
session_start();

// Autoload using PSR-4
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

// Parse routing parameters
$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

// Routing
switch ($page) {
    case 'devices':
        $controller = new \app\controllers\DeviceController();
        if ($action === 'add') {
            $controller->add();
        } else {
            $controller->index();
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
    case 'charts':
        $controller = new \app\controllers\ChartsController();
        if ($action === 'osPie') {
            $controller->osPie();
        } elseif ($action === 'soldBar') {
            $controller->soldBar();
        }
        break;
    case 'dashboard':
    default:
        $controller = new \app\controllers\DashboardController();
        $controller->index();
        break;
}
?>