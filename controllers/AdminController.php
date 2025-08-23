<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Auth;
use app\models\Device;

class AdminController extends BaseController
{
    public function index()
    {
        Auth::requireAdmin();
        $msg = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['datafile'])) {
            $msg = Device::import($_FILES['datafile']);
        }
        if (isset($_GET['export']) && in_array($_GET['export'], ['json', 'xml'])) {
            Device::export($_GET['export']);
            exit;
        }
        $this->render('admin/index', ['msg' => $msg]);
    }
}