<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if($request->isPost()){
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()){
                $response->redirect('/');
                return;
            }
        }
        $this->setLayout('general');
        $styles = "<link rel=\"stylesheet\" href=\"styles/signin_register.css\"/>";
        return $this->render('login',"Login",$styles, ['model' => $loginForm]);
    }

    public function register(Request $request)
    {
        $user = new User();
        $styles = "<link rel=\"stylesheet\" href=\"styles/signin_register.css\"/>";
        if($request->isPost())
        {

            $user->loadData($request->getBody());

            if($user->validate() && $user->save())
            {
                Application::$app->session->setFlash('success', "You have successfully registered!");
                Application::$app->response->redirectInTime(3, '/');
            }
            $this->setLayout('general');
            return $this->render('register',"Register",$styles,['model' =>$user]);
        }
        $this->setLayout('general');
        return $this->render('register',"Register",$styles,['model' =>$user]);
    }

    public function logout(Request $request, Response $response){
        Application::$app->logout();
        $response->redirect('/');
    }
}