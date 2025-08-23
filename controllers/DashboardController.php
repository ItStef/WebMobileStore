<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Auth;

class DashboardController extends BaseController
{
    public function index()
    {
        Auth::requireLogin();
        $this->render('dashboard/index');
    }
}