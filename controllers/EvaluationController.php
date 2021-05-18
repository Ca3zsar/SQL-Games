<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\models\Exercise;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['evaluateExercise']));
    }

    public function evaluateExercise(Request $request)
    {
        $params = $request->getBody();
        $exercise = new Exercise();


        if(isset($params["exerciseId"]))
        {
            $exercise->loadExercise($params["exerciseId"]);
            $status = Exercise::checkStatus(Application::$app->user->id,$exercise->id);
            $voteStatus = Exercise::checkVoted(Application::$app->user->id,$exercise->id);
            if($status == 1 && $voteStatus == 0)
            {
                $exercise->starExercise(Application::$app->user->id);
                echo json_encode(array("status"=>"star added","coins"=>Application::$app->user->coins,"stars"=>$exercise->stars,
                                        "boughtBy"=>$exercise->boughtBy,"solvedBy"=>$exercise->solvedBy));
                exit;
            }
        }else{
            echo json_encode(array("error"=>"exercise id not specified"));
            exit;
        }
    }
}