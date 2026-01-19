<?php
namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $pattern, callable $handler): void { $this->map('GET', $pattern, $handler); }
    public function post(string $pattern, callable $handler): void { $this->map('POST', $pattern, $handler); }

    private function map(string $method, string $pattern, callable $handler): void
    {
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';
        $this->routes[] = compact('method', 'regex', 'handler');
    }

    public function dispatch(Request $req): void
    {
        $path = $req->path();
        $method = $req->method();

        foreach ($this->routes as $r) {
            if ($r['method'] !== $method) continue;
            if (preg_match($r['regex'], $path, $m)) {
                $params = array_filter($m, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);
                ($r['handler'])($req, $params);
                return;
            }
        }
        http_response_code(404);
        echo "404 - Not Found";
    }
}
