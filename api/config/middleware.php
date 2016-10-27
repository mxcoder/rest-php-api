<?php
use GOG\Models\Cart as CartModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
