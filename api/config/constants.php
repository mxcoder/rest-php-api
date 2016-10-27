<?php
define('ENVIRONMENT', isset($_ENV['PHPENV']) ? $_ENV['PHPENV'] : 'DEVELOPMENT');
define('IS_PRODUCTION', ENVIRONMENT === 'PRODUCTION');
define('ROOT_DIR', dirname(dirname(__DIR__)));
define('API_CONFIG_DIR', __DIR__);
define('TMP_DIR', ROOT_DIR . '/tmp');
define('API_DIR', ROOT_DIR . '/api');
define('APP_DIR', ROOT_DIR . '/app');

// Propel runtime
if (is_file(API_DIR.'/config/propel-runtime.php')) {
    require_once API_DIR.'/config/propel-runtime.php';
}

// API GET page size
define('API_LIST_PAGE_SIZE', 3);

// Helper function for easy throws
function _throw($message, \Exception $e = null)
{
    throw new Exception($message, 0, $e);
}
