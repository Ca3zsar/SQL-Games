<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profileSettings']));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                $response->redirect('/');
                return;
            }
        }
        $this->setLayout('general');
        $styles = "<link rel=\"stylesheet\" href=\"styles/signin_register.css\"/>";
        return $this->render('login', "Login", $styles, ['model' => $loginForm]);
    }

    public function register(Request $request)
    {
        $user = new User();
        $styles = "<link rel=\"stylesheet\" href=\"styles/signin_register.css\"/>";
        if ($request->isPost()) {

            $user->loadData($request->getBody());

            if ($user->validate() && $user->saveUser()) {
                Application::$app->session->setFlash('success', "You have successfully registered!");
                Application::$app->response->redirectInTime(3, '/');
            }
            $this->setLayout('general');
            return $this->render('register', "Register", $styles, ['model' => $user]);
        }
        $this->setLayout('general');
        return $this->render('register', "Register", $styles, ['model' => $user]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profileSettings()
    {
        $styles = '<link rel="stylesheet" title="extended" type="text/css" href="styles/profile_settings.css"/>';
        $this->setLayout('general');
        return $this->render('profile_settings', "Profile Settings", $styles);
    }
}