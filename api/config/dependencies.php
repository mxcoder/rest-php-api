<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// Logger injection
$container = $app->getContainer();
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $file_handler = new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']);
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['notFoundHandler'] = function ($c) {
    return function (ServerRequestInterface $request, ResponseInterface $response) use ($c) {
        return $response->withRedirect('/api/');
    };
};
