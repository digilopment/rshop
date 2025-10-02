<?php

use function Cake\Core\env;

return [
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    'Security' => [
        'salt' => env('SECURITY_SALT', 'd8860535d14dc7d387889f61abc332b9835e1b0634f756ca98c0387a335457bc'),
    ],
    'Datasources' => [
        'default' => [
            'host' => 'rshop-db',
            'port' => '3306',
            'username' => 'root',
            'password' => 'root',
            'database' => 'rshop',
            'driver' => 'Cake\Database\Driver\Mysql',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'cacheMetadata' => false,
        ],
    ],
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
