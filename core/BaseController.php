<?php

namespace app\core;

class BaseController
{
    protected function render($viewPath, $variables = [])
    {
        extract($variables);
        require __DIR__ . "/../views/$viewPath.php";
    }

    protected function redirect($page, $params = [])
    {
        $query = http_build_query(array_merge(['page' => $page], $params));
        header("Location: /index.php?$query");
        exit;
    }
}