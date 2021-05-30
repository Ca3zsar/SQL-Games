<?php


namespace app\core\middlewares;


use app\core\Application;
use app\core\exception\ForbiddenException;
use app\core\Request;
use app\models\Creator;

class AuthorMiddleware extends BaseMidleware
{

    public array $actions = [];

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        $request = new Request();

        $path = $request->getPath();
        $id = substr($path, strlen("/exercise_creator/") );


        if ((Application::isGuest() ||  !Creator::isExerciseAuthor($id)) && in_array(Application::$app->controller->action, $this->actions)){
            throw new ForbiddenException();
    }
    }
}