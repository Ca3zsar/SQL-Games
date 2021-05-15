<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Exercise;

class ExerciseController extends Controller
{
    public function specificExercise(Request $request, Response $response)
    {
        $exercise = new Exercise();

        $path = $request->getPath();
        $id = substr($path,strlen("/exercise/")+1);

        $exercise->loadExercise($id);

        $styles = '<link rel="stylesheet" href="/styles/exercise.css" />
                    <link rel="stylesheet" href="/styles/code_editor.css" />';

        $this->setLayout('general');
        return $this->render('exercise',"#Exercise ID",$styles,['model' => $exercise]);
    }

    public function exercise()
    {
        $styles = '<link rel="stylesheet" href="styles/exercise.css" />
                    <link rel="stylesheet" href="styles/code_editor.css" />';

        $this->setLayout('general');
        return $this->render('exercise',"#Exercise ID",$styles);
    }
}