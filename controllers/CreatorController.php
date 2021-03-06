<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\AuthorMiddleware;
use app\core\Request;
use app\models\Achievements;
use app\models\Creator;
use app\models\Exercise;

class CreatorController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['viewCreator']));
        $this->registerMiddleware(new AuthMiddleware(['creator']));
        $this->registerMiddleware(new AuthorMiddleware(['viewEditor']));
        $this->registerMiddleware(new AuthorMiddleware(['editExercise']));
    }

    public function viewCreator()
    {
        $creator = new Creator();
        $styles = '<link rel="stylesheet" href="/styles/creator.css" />
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/styles/default.min.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/arduino-light.min.css">';

        $this->setLayout('general');
        return $this->render('exercise_creator', "Add Exercise", $styles, ['model' => $creator]);

    }

    public function creator(Request $request)
    {
        $data = $request->getBody();
        $data["authorId"] =  (int)Application::$app->session->get('user');
        $data["password"] = Application::$app->user->password;
        $data["username"] = Application::$app->user->username;

        $data["correctQuery"] = htmlspecialchars_decode($data["correctQuery"]);

        $data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/create_exercises.php");

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);
        curl_close($curl);

        if(empty($result->errors))
        {
            Achievements::updateAchievements(Application::$app->user->id);
        }

        echo $result;
    }

    public function viewEditor(Request $request)
    {
        //Get the id of the edited exercise from the path
        $path = $request->getPath();
        $id = substr($path, strlen("/exercise_creator/") );

        $exercise = new Exercise();

        try {
            $exercise->loadExercise($id);
        } catch (NotFoundException) {
        }

        $creator = new Creator($exercise);
        $styles = '<link rel="stylesheet" href="/styles/creator.css" />
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/styles/default.min.css">
                    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/arduino-light.min.css">';

        $this->setLayout('general');
        return $this->render('exercise_creator', "Edit Exercise #$id", $styles, ['model' => $creator]);
    }

    public function editExercise(Request $request)
    {
        $data = $request->getBody();
        $data["authorId"] =  (int)Application::$app->session->get('user');
        $data["password"] = Application::$app->user->password;
        $data["username"] = Application::$app->user->username;

        $data["correctQuery"] = htmlspecialchars_decode($data["correctQuery"]);

        $data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/create_exercises.php");

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);
        curl_close($curl);
        echo $result;
    }
}