<?php
define('ROOT_DIR', __DIR__);
define('TMP_DIR', ROOT_DIR . '/tmp');
define('API_DIR', ROOT_DIR . '/api');
define('APP_DIR', ROOT_DIR . '/app');
// Global settings
setlocale(LC_ALL, 'en_US.UTF-8');
session_save_path(TMP_DIR.'/sessions/');
// API GET page size
define('LIST_PAGE_SIZE', 3);
define('NON_EXISTING_ID', 999999999);

