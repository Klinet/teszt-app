<?php

namespace App\Classes;

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $handler): void
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch(): void
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