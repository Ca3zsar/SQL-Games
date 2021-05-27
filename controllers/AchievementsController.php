<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\models\Creator;
use app\models\Achievements;

class AchievementsController extends \app\core\Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['showAchievements']));

    }

    public function showAchievements(Request $request)
    {

        $styles = '<link rel="stylesheet" href="styles/achievements.css" />';
        $this->setLayout('general');
        return $this->render('achievements', "Achievements", $styles);
    }

//    public function showCoins(){
//        $coins = Application::$app->user->coins;
//        echo $coins;
//
//    }


}