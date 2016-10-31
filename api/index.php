<?php
require dirname(__DIR__).'/vendor/autoload.php';
require API_DIR.'/config/constants.php';

session_start();

$app = new Slim\App(require(API_CONFIG_DIR.'/slim.php'));
require_once API_CONFIG_DIR.'/dependencies.php';
require_once API_CONFIG_DIR.'/middleware.php';
require_once API_CONFIG_DIR.'/routes.php';

$app->run();
