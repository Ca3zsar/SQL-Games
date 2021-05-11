<?php

namespace app\core;

use app\models\Creator;

class Application
{
    public string $userClass;
    public string $creatorClass;
    public static string $ROOT_DIR;
    public string $layout = 'general';
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public static Application $app;
    public Session $session;
    public ?Controller $controller = null;
    public ?DBModel $user;
    public ?DBModel $creator;
    public array $errorTitles = ['404' => 'Not found', '403' => 'Forbidden'];

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        $this->creatorClass = $config['creatorClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->creator = new Creator();
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = (new $this->userClass)->primaryKey();
            $this->user = (new $this->userClass)->findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            $styles = '<link rel="stylesheet" title="extended" type="text/css" href="styles/error.css"/>';
            echo $this->router->renderView('_error', $this->errorTitles[$e->getCode()], $styles, ['exception' => $e]);
        }
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(DBModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function register(DBModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}