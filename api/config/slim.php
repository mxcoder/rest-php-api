<?php
setlocale(LC_ALL, 'en_US.UTF-8');
session_save_path(TMP_DIR.'/sessions/');
session_start();

return [
    'settings' => [
        'displayErrorDetails' => true,
        'outputBuffering' => false,
        'logger' => [
            'name' => 'apiLogger',
            'level' => \Monolog\Logger::DEBUG,
            'path' => TMP_DIR.'/app.log',
        ],
    ],
];
