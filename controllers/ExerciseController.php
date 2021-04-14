<?php


namespace app\controllers;


use app\core\Controller;

class ExerciseController extends Controller
{
    public function exercise()
    {
        $styles = '<link rel="stylesheet" href="styles/exercise.css" />
                    <link rel="stylesheet" href="styles/code_editor.css" />';

        $this->setLayout('general');
        return $this->render('exercise',"#Exercise ID",$styles);
    }
}