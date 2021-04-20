<?php


namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

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
        $registerModel = new RegisterModel();
        $styles = "<link rel=\"stylesheet\" href=\"styles/signin_register.css\"/>";
        if($request->isPost())
        {

            $registerModel->loadData($request->getBody());

            if($registerModel->validate() && $registerModel->register())
            {
                return 'Success';
            }
            var_dump($registerModel->errors);
            exit;
            $this->setLayout('general');
            return $this->render('register',"Register",$styles,['model' =>$registerModel]);
        }
        $this->setLayout('general');
        return $this->render('register',"Register",$styles,['model' =>$registerModel]);
    }
}