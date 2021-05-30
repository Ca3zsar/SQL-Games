<?php


namespace app\controllers;

use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\models\Achievements;

class AchievementsController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['showAchievements']));
    }

    public function showAchievements()
    {
        $achievementsList = Achievements::loadAchievements();

        $styles = '<link rel="stylesheet" href="styles/achievements.css" />';
        $this->setLayout('general');
        return $this->render('achievements', "Achievements", $styles,['achievements' => $achievementsList]);
    }
}