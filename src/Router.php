<?php
namespace App;
class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable|array $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo "404 - Page not found";
            return;
        }

        $handler = $this->routes[$method][$uri];

        // Controller method
        if (is_array($handler)) {
            [$class, $method] = $handler;
            $controller = new $class();
            call_user_func([$controller, $method]);
        } 
        // Anonymous function
        else {
            call_user_func($handler);
        }
    }
}
