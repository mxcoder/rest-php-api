<?php
// Propel connections
require_once API_DIR.'/config/propel-runtime.php';

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
    return function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response) use ($c) {
        return $response->withRedirect('/api/');
    };
};
