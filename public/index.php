<?php

require_once __DIR__ . '/../vendor/autoloader.php';
use app\core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get('/','home');

$app->router->get('/contact','contact');

$app->router->post('/contact',function(){
    return 'handling data';
});

$app->run();