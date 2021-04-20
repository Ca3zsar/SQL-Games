<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use app\controllers\ExerciseController;
use app\controllers\ShopController;
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

$app = new Application(dirname(__DIR__));

$app->router->get('/',[SiteController::class, 'home']);
$app->router->get('/home',[SiteController::class, 'home']);
$app->router->get('/contact',[SiteController::class,'contact']);
$app->router->post('/contact',[SiteController::class,'handleContact']);

$app->router->get('/login',[AuthController::class,'login']);
$app->router->post('/login',[AuthController::class,'login']);

$app->router->get('/shop',[ShopController::class, 'shop']);
$app->router->post('/shop',[ShopController::class, 'shop']);

$app->router->get('/exercise',[ExerciseController::class,'exercise']);
$app->router->get('/exercise',[ExerciseController::class,'exercise']);

$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/register',[AuthController::class,'register']);

$app->run();
