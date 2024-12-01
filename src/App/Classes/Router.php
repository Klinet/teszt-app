<?php

namespace App\Classes;

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $handler)
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] == $requestMethod && $route['path'] == $requestUri) {
                call_user_func($route['handler']);
                return;
            }
        }
    }
}