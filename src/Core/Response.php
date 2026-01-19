<?php
namespace App\Core;

final class Response
{
    public function redirect(string $to): void
    {
        header('Location: ' . $to);
        exit;
    }
}
