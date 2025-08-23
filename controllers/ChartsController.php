<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\Device;

class ChartsController extends BaseController
{
    public function osPie()
    {
        $data = Device::osStats();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function soldBar()
    {
        $data = Device::soldStats();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}