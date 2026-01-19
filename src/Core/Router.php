<?php
namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $pattern, callable $handler): void
    {
        $this->add('GET', $pattern, $handler);
    }

    public function post(string $pattern, callable $handler): void
    {
        $this->add('POST', $pattern, $handler);
    }

    private function add(string $method, string $pattern, callable $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'segments' => $this->split($pattern),
            'handler' => $handler,
        ];
    }

    private function split(string $path): array
    {
        $path = trim($path, '/');       
        if ($path === '') return [];    
        return explode('/', $path);
    }

    public function dispatch(Request $req): void
    {
        $method = strtoupper($req->method());
        $pathSegments = $this->split($req->path());

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;

            $patternSegments = $route['segments'];
            if (count($patternSegments) !== count($pathSegments)) continue;

            $params = [];
            $matched = true;

            for ($i = 0; $i < count($patternSegments); $i++) {
                $p = $patternSegments[$i];
                $v = $pathSegments[$i];


                if (strlen($p) >= 3 && $p[0] === '{' && $p[strlen($p)-1] === '}') {
                    $key = substr($p, 1, -1);  
                    $params[$key] = $v;
                    continue;
                }
                
                if ($p !== $v) {
                    $matched = false;
                    break;
                }
            }

            if ($matched) {
                ($route['handler'])($req, $params);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Not Found";
    }
}
