<?php

return [
    'settings' => [
        'displayErrorDetails' => (bool) getenv('APP_DEBUG'),
        'app' => [
            'name' => getenv('APP_NAME'),
        ],
        'db' => [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION')
        ]
    ]
];