<?php

namespace App\Core;

abstract class Controller
{
    protected function view($name, $data = [])
    {
        $base = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        if ($base === '/') $base = '';
        $data['base'] = $base;

        extract($data);
        $viewFile = __DIR__ . "/../Views/{$name}.php";

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View {$name} not found.");
        }
    }

    protected function redirect($url)
    {
        $target = $url;
        if (strpos($url, 'http') !== 0) {
            $target = \App\Core\Router::url($url);
        }
        header("Location: {$target}");
        exit;
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
