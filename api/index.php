<?php
session_start();
setlocale(LC_ALL, 'en_US.UTF-8');

require dirname(__DIR__).'/vendor/autoload.php';
require API_DIR.'/config/constants.php';

$app = new Slim\App(require(API_CONFIG_DIR.'/slim.php'));
require_once API_CONFIG_DIR.'/dependencies.php';
require_once API_CONFIG_DIR.'/middleware.php';
require_once API_CONFIG_DIR.'/routes.php';

$app->run();
