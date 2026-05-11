<?php

namespace App\Core;

class Router
{
    protected $routes = [];
    protected static $basePath = null;

    public static function getBase()
    {
        if (self::$basePath === null) {
            $scriptName = $_SERVER['SCRIPT_NAME'];
            self::$basePath = str_replace('/index.php', '', $scriptName);
            if (self::$basePath === '/') self::$basePath = '';
        }
        return self::$basePath;
    }

    public static function url($path)
    {
        return self::getBase() . $path;
    }

    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch($method, $uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $basePath = self::getBase();

        if ($basePath !== '' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        if ($uri === '') $uri = '/';

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = "#^" . $pattern . "$#";

            if ($route['method'] === strtoupper($method) && preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return $this->callHandler($route['handler'], $params);
            }
        }

        return $this->abort(404);
    }

    protected function callHandler($handler, $params)
    {
        if (is_array($handler)) {
            [$controller, $method] = $handler;
            $controller = new $controller();
            return $controller->$method($params);
        }

        return $handler($params);
    }

    protected function abort($code = 404)
    {
        http_response_code($code);
        echo "Error $code: Not Found";
        exit;
    }
}
