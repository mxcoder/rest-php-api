<?php
return [
    'settings' => [
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'apiLogger',
            'level' => \Monolog\Logger::DEBUG,
            'path' => TMP_DIR.'/app.log',
        ],
    ],
];
