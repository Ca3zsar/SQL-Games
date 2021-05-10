<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Creator;

class CreatorController extends Controller
{
    public function creator(Request $request, Response $response)
    {
        $creator = new Creator();

        if ($request->isPost()) {
            $creator->loadData($request->getBody());
        }

        $styles = '<link rel="stylesheet" href="styles/creator.css" />
                    <link rel="stylesheet" href="styles/code_editor.css" />';

        $this->setLayout('general');
        return $this->render('exercise_creator',"Add Exercise",$styles);
    }
}