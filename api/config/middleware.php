<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// App session middleware
$app->add(function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
    $_SESSION['carts'] = isset($_SESSION['carts']) ? $_SESSION['carts'] : [];

    $response = $next($request, $response);

    return $response;
});
