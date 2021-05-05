<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('general');
        $styles = "<link rel=\"stylesheet\" href=\"styles/signin_register.css\"/>";
        return $this->render('login',"Login",$styles);
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
                Application::$app->response->redirect('/');
            }
            $this->setLayout('general');
            return $this->render('register',"Register",$styles,['model' =>$user]);
        }
        $this->setLayout('general');
        return $this->render('register',"Register",$styles,['model' =>$user]);
    }
}