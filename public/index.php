<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use app\controllers\AchievementsController;
use app\controllers\CreatorController;
use app\controllers\EvaluationController;
use app\controllers\ExerciseController;
use app\controllers\HistoryController;
use app\controllers\SettingsController;
use app\controllers\StatisticsController;
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

$app->router->get('/exercises',[ShopController::class,'exercises']);
$app->router->get('/exercise',[ExerciseController::class,'exercise']);

$app->router->getRegex('/exercises\/([0-9]*)$/', [ExerciseController::class, 'specificExercise']);
$app->router->postRegex('/exercises\/([0-9]*)$/', [ExerciseController::class, 'exerciseManager']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/getExercises',[ShopController::class,'loadExercises']);

$app->router->get('/profile_settings', [SettingsController::class, 'profileSettings']);
$app->router->post('/profile_settings', [SettingsController::class, 'changeSettings']);

$app->router->get('/exercise_creator', [CreatorController::class, 'viewCreator']);
$app->router->post('/exercise_creator',[CreatorController::class, 'creator']);
$app->router->getRegex('/exercise_creator\/([0-9]*)$/', [CreatorController::class, 'viewEditor']);
$app->router->postRegex('/exercise_creator\/([0-9]*)$/', [CreatorController::class, 'editExercise']);

$app->router->post('/evaluation',[EvaluationController::class,'evaluateExercise']);
$app->router->get('/history',[HistoryController::class,'showHistory']);

$app->router->get('/achievements',[AchievementsController::class,'showAchievements']);

$app->router->get('/statistics', [StatisticsController::class, 'statistics']);
$app->router->get('/getStatistics',[StatisticsController::class,'getStats']);

$app->run();
