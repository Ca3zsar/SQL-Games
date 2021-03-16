<?php

require_once __DIR__.'/../autoload/autoloader.php';
use app\core\Application;

$app = new Application();

$app->router->get('/',function(){
    return 'Hello World';
});

$app->router->get('/contact',function(){
    return 'Contact';
});

$app->run();