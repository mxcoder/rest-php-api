<?php
// Home
$app->any('/', '\GOG\Controllers\Base::home');

// v1 API endpoints
$app->group('/v1', function () {
    $this->any('/', '\GOG\Controllers\Base::home');
    $this->any('/carts[/{id:[0-9]*}[/{action}]]', '\GOG\Controllers\Carts');
    $this->any('/products[/{id:[0-9]*}[/{action}]]', '\GOG\Controllers\Products');
})->add('\GOG\Controllers\Base::propelMiddleWare');
