<?php
namespace App\Core;

final class Request
{
    public function method(): string { return $_SERVER['REQUEST_METHOD'] ?? 'GET'; }

    public function path(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH);
        return $path ?: '/';
    }

    public function input(string $key, $default = null)
    {
        $data = $this->method() === 'POST' ? $_POST : $_GET;
        return $data[$key] ?? $default;
    }
}
