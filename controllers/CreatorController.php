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

    public function viewCreator()
    {
        $creator = new Creator(Application::$app->session->get('id'));
        $styles = '<link rel="stylesheet" href="styles/creator.css" />';

        $this->setLayout('general');
        return $this->render('exercise_creator', "Add Exercise", $styles, ['model' => $creator]);

    }

    public function creator(Request $request, Response $response)
    {
        $creator = new Creator(Application::$app->session->get('id'));
        $styles = '<link rel="stylesheet" href="styles/creator.css" />';

        $data = $request->getBody();
        $data["authorId"] =  (int)Application::$app->session->get('user');

        $data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/exercises.php");

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);
        curl_close($curl);

        echo $result;

//        if(empty($result['errors'])) {
//            Application::$app->response->redirectInTime(3, '/');
//        }
//
//        $this->setLayout('general');
//        return $this->render('exercise_creator', "Add Exercise", $styles, ['model' => $creator]);
    }

}