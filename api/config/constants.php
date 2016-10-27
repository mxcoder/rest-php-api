<?php
define('ENVIRONMENT', isset($_ENV['PHPENV']) ? $_ENV['PHPENV'] : 'DEVELOPMENT');
define('IS_PRODUCTION', ENVIRONMENT === 'PRODUCTION');
define('ROOT_DIR', dirname(dirname(__DIR__)));
define('API_CONFIG_DIR', __DIR__);
define('TMP_DIR', ROOT_DIR . '/tmp');
define('API_DIR', ROOT_DIR . '/api');
define('APP_DIR', ROOT_DIR . '/app');
// If propel runtime file is available, load it
if (is_file(API_DIR.'/config/propel-runtime.php')) {
    require_once API_DIR.'/config/propel-runtime.php';
}

define('API_LIST_PAGE_SIZE', 3);
