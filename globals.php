<?php
define('ROOT_DIR', __DIR__);
define('TMP_DIR', ROOT_DIR . '/tmp');
define('API_DIR', ROOT_DIR . '/api');
define('APP_DIR', ROOT_DIR . '/app');
define('ENVIRONMENT', isset($_ENV['PHPENV']) ? $_ENV['PHPENV'] : 'DEVELOPMENT');
define('IS_PRODUCTION', ENVIRONMENT === 'PRODUCTION');

// API GET page size
define('LIST_PAGE_SIZE', 3);
