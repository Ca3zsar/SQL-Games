<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use app\controllers\CreatorController;
use app\controllers\ExerciseController;
use app\controllers\ShopController;
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\DotEnv;
use app\models\Creator;
use app\models\User;

(new DotEnv(dirname(__DIR__) . '/.env'))->load();

$config = [
    'creatorClass' => Creator::class,
    'userClass' => User::class,
    'db' => [
        'dsn' => getenv('DB_DSN'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD')
    ]
];


$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/home', [SiteController::class, 'home']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/shop', [ShopController::class, 'shop']);
$app->router->post('/shop', [ShopController::class, 'shop']);

$app->router->get('/exercise', [ExerciseController::class, 'exercise']);
$app->router->get('/exercise', [ExerciseController::class, 'exercise']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/profile_settings', [AuthController::class, 'profileSettings']);

$app->router->get('/exercise_creator', [CreatorController::class, 'creator']);
$app->router->post('/exercise_creator',[CreatorController::class, 'creator']);

$app->run();
