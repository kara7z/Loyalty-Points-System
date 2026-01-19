<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;
use App\Core\View;

use App\Model\User;
use App\Model\PointsTransaction;
use App\Model\Reward;
use App\Model\Purchase;
use App\Model\Product;

use App\Service\AuthService;
use App\Service\PointsCalculator;
use App\Service\PointsService;
use App\Service\PurchaseService;
use App\Service\CartService;

use App\Controller\AuthController;
use App\Controller\ProductController;
use App\Controller\CartController;
use App\Controller\CheckoutController;
use App\Controller\DashboardController;
use App\Controller\PointsController;
use App\Controller\RewardsController;

// Boot
$config = require __DIR__ . '/../config/database.php';
$pdo = Database::pdo($config);

$session = new Session();
$session->start();

$req = new Request();
$res = new Response();
$view = new View(__DIR__ . '/../templates');

// DI
$userModel = new User($pdo);
$txModel = new PointsTransaction($pdo);
$rewardModel = new Reward($pdo);
$purchaseModel = new Purchase($pdo);
$productModel = new Product($pdo);

$authService = new AuthService($userModel, $session);
$calculator  = new PointsCalculator();
$pointsService = new PointsService($pdo, $userModel, $txModel, $rewardModel);
$purchaseService = new PurchaseService($pdo, $purchaseModel, $calculator, $pointsService);
$cartService = new CartService($session, $productModel);

$userId = $authService->userId();
$cartCount = $cartService->count();
$flash = $session->flash('msg');

$view->globals([
  'userId' => $userId,
  'cartCount' => $cartCount,
  'flash' => $flash
]);

$authController = new AuthController($view, $res, $session, $authService);
$productController = new ProductController($view, $productModel);
$cartController = new CartController($view, $res, $session, $cartService);
$checkoutController = new CheckoutController($view, $res, $session, $userModel, $cartService, $purchaseService);

$dashboardController = new DashboardController($view, $userModel);
$pointsController = new PointsController($view, $txModel);
$rewardsController = new RewardsController($view, $res, $session, $rewardModel, $pointsService);

// Helpers
$requireAuth = function() use ($authService, $res) : int {
    if (!$authService->userId()) {
        $res->redirect('/login');
    }
    return $authService->requireLogin();
};

$router = new Router();

// Home: login first, then products
$router->get('/', function($req) use ($authService, $res) {
    if ($authService->userId()) $res->redirect('/products');
    $res->redirect('/login');
});

// Auth routes
$router->get('/login', fn($req) => $authController->showLogin($req));
$router->post('/login', fn($req) => $authController->login($req));
$router->get('/register', fn($req) => $authController->showRegister($req));
$router->post('/register', fn($req) => $authController->register($req));
$router->get('/logout', fn($req) => $authController->logout($req));

// Protected routes
$router->get('/products', function($req) use ($requireAuth, $productController) {
    $requireAuth();
    $productController->index($req);
});

$router->get('/cart', function($req) use ($requireAuth, $cartController) {
    $requireAuth();
    $cartController->show($req);
});
$router->post('/cart/add/{id}', function($req, $p) use ($requireAuth, $cartController) {
    $requireAuth();
    $cartController->add($req, $p);
});
$router->post('/cart/remove/{id}', function($req, $p) use ($requireAuth, $cartController) {
    $requireAuth();
    $cartController->remove($req, $p);
});

$router->get('/checkout', function($req) use ($requireAuth, $checkoutController) {
    $requireAuth();
    $checkoutController->show($req);
});
$router->post('/checkout', function($req) use ($requireAuth, $checkoutController) {
    $userId = $requireAuth();
    $checkoutController->pay($req, $userId);
});
$router->get('/checkout/success', function($req) use ($requireAuth, $checkoutController) {
    $requireAuth();
    $checkoutController->success($req);
});

$router->get('/dashboard', function($req) use ($requireAuth, $dashboardController) {
    $userId = $requireAuth();
    $dashboardController->index($req, $userId);
});
$router->get('/points/history', function($req) use ($requireAuth, $pointsController) {
    $userId = $requireAuth();
    $pointsController->history($req, $userId);
});
$router->get('/rewards', function($req) use ($requireAuth, $rewardsController) {
    $requireAuth();
    $rewardsController->index($req);
});
$router->post('/rewards/redeem/{id}', function($req, $p) use ($requireAuth, $rewardsController) {
    $userId = $requireAuth();
    $rewardsController->redeem($req, $userId, $p);
});

$router->dispatch($req);
