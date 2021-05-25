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
            $data = $request->getBody();

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/authentication/login.php");

            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            $result = curl_exec($curl);
            $result = json_decode($result,1);

            $loginForm->loadData($request->getBody());
            $statusCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
            curl_close($curl);

            if($statusCode == 401)
            {
                $loginForm->errors = $result["errors"];
            }else{
                $user = (new User)->findOne(['username' => $data["username"]]);
                if(Application::$app->login($user))
                {
                    $response->redirect('/');
                    return;
                }
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
            $data = $request->getBody();

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/authentication/create_user.php");

            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            $result = curl_exec($curl);
            curl_close($curl);

            $result = json_decode($result,1);
            $user->loadData($request->getBody());

            if(isset($result["errors"]))
            {
                $user->errors = $result["errors"];
            }else{
                $newUser = (new User)->findOne(['username' => $user->username]);
                if(Application::$app->register($newUser)) {
                    Application::$app->session->setFlash('success', "You have successfully registered!");
                    Application::$app->response->redirectInTime(3, '/');
                }
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


}