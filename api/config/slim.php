<?php
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
