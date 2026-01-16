<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\PageController;
use App\Router;
use App\Controller\ShopController;

$router = new Router();

/* ---------- ROUTES ---------- */

$router->get('/', function () {
    echo "Home";
});

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

// $router->get('/points', [PointsController::class, 'index']);
$router->get('/shop', [ShopController::class, 'index']);

/* ---------- DISPATCH ---------- */

$router->dispatch();

