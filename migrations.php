<?php

require_once __DIR__ . '/vendor/autoloader.php';

use app\controllers\ExerciseController;
use app\controllers\ShopController;
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\DotEnv;

(new DotEnv(__DIR__ . '/.env'))->load();

$config = [
    'creatorClass' => \app\models\Creator::class,
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => getenv('DB_DSN'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD')
    ]
];


$app = new Application(__DIR__,$config);

$app->db->applyMigrations();
