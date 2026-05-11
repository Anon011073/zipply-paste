<?php

namespace App\Core;

abstract class Controller
{
    protected function view($name, $data = [])
    {
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
        header("Location: {$url}");
        exit;
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
