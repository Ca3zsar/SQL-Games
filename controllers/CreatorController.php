<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\Creator;

class CreatorController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['creator']));
    }

    public function creator(Request $request, Response $response)
    {
        $creator = new Creator();

        if ($request->isPost()) {
            $creator->loadData($request->getBody());
        }

        $styles = '<link rel="stylesheet" href="styles/creator.css" />';

        $this->setLayout('general');
        return $this->render('exercise_creator', "Add Exercise", $styles,['model' => $creator]);
    }

    public function rules(): array
    {
        return ['username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function tableName(): string
    {
        return 'unverifiedex';
    }
}