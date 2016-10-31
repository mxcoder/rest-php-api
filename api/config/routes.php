<?php
// Home
$app->get('/', '\GOG\Controllers\Base::home')->setName('home');
// v1 API endpoints
$app->group('/v1', function () {
    // Options REST
    $this->options('/carts', '\GOG\Controllers\Carts');
    $this->options('/products', '\GOG\Controllers\Products');
    // Active REST
    $this->map(['GET', 'POST', 'PUT', 'DELETE'], '/carts[/{id:[0-9]*}[/{action}]]', '\GOG\Controllers\Carts');
    $this->map(['GET', 'POST', 'PUT', 'DELETE'], '/products[/{id:[0-9]*}[/{action}]]', '\GOG\Controllers\Products');
});
