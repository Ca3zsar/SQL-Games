<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use \app\core\Database;
use \app\core\DotEnv;

function getDatabaseConnection(): Database
{
    (new DotEnv(__DIR__ . '/.env'))->load();
    $config = [
        'db' => [
            'dsn' => getenv('DB_DSN'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD')
        ]
    ];
    return new Database($config['db']);
}