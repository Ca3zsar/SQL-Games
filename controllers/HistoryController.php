<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\models\History;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['showHistory']));

    }

    public function showHistory()
    {
        $history = new History();

        $history->loadHistory(Application::$app->user->id);

        $styles = '<link rel="stylesheet" href="styles/history.css" />';

        $this->setLayout('general');
        return $this->render('history', "History and Stats", $styles, ['model' => $history]);
    }
}