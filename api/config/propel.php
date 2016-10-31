<?php
return [
    'propel' => [
        'general' => [
            'project' => 'GOG/PHPAPI',
        ],
        'paths' => [
            'schemaDir' => API_DIR.'/src/database/',
            'phpConfDir' => API_DIR.'/config/',
            'phpDir' => TMP_DIR.'/generated/php/',
            'migrationDir' => API_DIR.'/src/migration/',
            'sqlDir' => API_DIR.'/src/database/',
            'composerDir' => ROOT_DIR
        ],
        'database' => [
            'connections' => [
                'default' => [
                    'adapter' => 'sqlite',
                    // 'classname' => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'classname' => 'Propel\Runtime\Connection\DebugPDO',
                    'dsn' => 'sqlite:'.TMP_DIR.'/gog.db',
                    'user' => 'na',
                    'password' => 'na',
                    'settings' => [
                        'charset' => 'utf8'
                    ]
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'default',
            'connections' => ['default'],
            'log' => [
                'defaultLogger' => [
                    'type' => 'stream',
                    'path' => TMP_DIR.'/propel.log',
                    'level' => \Monolog\Logger::DEBUG
                ],
            ],
        ],
        'generator' => [
            'defaultConnection' => 'default',
            'connections' => ['default'],
            // 'platformClass' => 'Propel\Generator\Platform\SqlitePlatform',
            'dateTime' => [
                'useDateTimeClass' => true,
            ],
            'namespaceAutoPackage' => true,
            'objectModel' => [
                'addClassLevelComment' => false
            ]
        ]
    ]
];
