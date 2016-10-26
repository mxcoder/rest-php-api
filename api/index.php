<?php
session_start();
require '../vendor/autoload.php';

use GOG\Models\Cart as CartModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$app = new Slim\App(require(API_DIR.'/config/slim.php'));
// App session middleware
$app->add(function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
    // Create a cart if there's none
    if (!isset($_SESSION['cart_id'])) {
        $Cart = new CartModel();
        $Cart->save();
        $_SESSION['cart_id'] = $Cart->getId();
    }
    $request = $request->withAttribute('session', $_SESSION);
    return $next($request, $response);
});
// Home route
$app->any('/', function (ServerRequestInterface $request, ResponseInterface $response, callable $args) {
    $response->write("Hello");
    return $response;
});
// API endpoints
$app->group('/', function () {
    $this->any('carts[/{id:[0-9]*}[/{action}]]', '\GOG\Controllers\Carts');
    $this->any('products[/{id:[0-9]*}[/{action}]]', '\GOG\Controllers\Products');
})->add('\GOG\Controllers\Base::propelMiddleWare');

$app->run();
