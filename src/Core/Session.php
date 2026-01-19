<?php
namespace App\Core;

final class Session
{
    public function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function set(string $key, $value): void { $_SESSION[$key] = $value; }
    public function get(string $key, $default = null) { return $_SESSION[$key] ?? $default; }
    public function remove(string $key): void { unset($_SESSION[$key]); }

    public function flash(string $key, ?string $value = null): ?string
    {
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return null;
        }
        $msg = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $msg;
    }
}
