<?php
// Home
$app->any('/', '\GOG\Controllers\Base::home')->setName('home');
// v1 API endpoints
$app->group('/v1', function () {
    // Home
    // $this->any('/', '\GOG\Controllers\Base::home');
    // Options REST
    $this->options('/carts', '\GOG\Controllers\Carts');
    $this->options('/products', '\GOG\Controllers\Products');
    // Active REST
    $this->group('', function () {
        $this->map(['GET', 'POST', 'DELETE'], '/carts[/{id:[0-9]*}[/{action}]]', '\GOG\Controllers\Carts');
        $this->map(['GET', 'POST', 'PUT', 'DELETE'], '/products[/{id:[0-9]*}[/{action}]]', '\GOG\Controllers\Products');
    })->add('\GOG\Controllers\Base::propelMiddleWare');

});
