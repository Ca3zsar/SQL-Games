<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\Statistics;

class StatisticsController extends Controller
{

    public function statistics(Request $request)
    {
        $statistics = new Statistics();

        $statistics->loadStats();
    }
}