<?php
// Environment based on server env
define('ENVIRONMENT', isset($_ENV['PHPENV']) ? $_ENV['PHPENV'] : 'DEVELOPMENT');
define('IS_PRODUCTION', ENVIRONMENT === 'PRODUCTION');
// API constants
define('API_CONFIG_DIR', __DIR__);
