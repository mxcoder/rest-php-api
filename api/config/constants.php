<?php
// API constants
define('API_CONFIG_DIR', __DIR__);
// Propel runtime
if (is_file(API_DIR.'/config/propel-runtime.php')) {
    require_once API_DIR.'/config/propel-runtime.php';
}
