<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\Statistics;
use app\core\Application;

class StatisticsController extends Controller
{
    public function getStats(Request $request)
    {
        $statistics = new Statistics();

        $statistics->loadStats();
        echo json_encode($statistics->finalStats);
    }

    public function statistics(Request $request)
    {
        $statistics = new Statistics();

        $statistics->loadStats();

        $styles = '<link rel="stylesheet" href="styles/history.css" />
                    <link rel="stylesheet" href="styles/statistics.css" />';

        $this->setLayout('general');
        return $this->render('statistics', "General Stats", $styles, ['model' => $statistics]);
    }
}