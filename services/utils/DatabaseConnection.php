<?php

namespace app\services\utils;

use \app\core\Database;
use \app\core\DotEnv;

class DatabaseConnection
{
    static function getDatabaseConnection(): Database
    {
        (new DotEnv(__DIR__ . '/../.env'))->load();
        $config = [
            'db' => [
                'dsn' => getenv('DB_DSN'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD')
            ]
        ];
        return new Database($config['db']);
    }
}