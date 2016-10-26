<?php
return [
    'settings' => [
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'slim-app',
            'level' => \Monolog\Logger::DEBUG,
            'path' => TMP_DIR . '/app.log',
        ],
    ],
];
