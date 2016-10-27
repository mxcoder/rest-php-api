<?php
// Logger injection
$container = $app->getContainer();
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($settings['name']);
    $file_handler = new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']);
    $logger->pushHandler($file_handler);
    return $logger;
};
