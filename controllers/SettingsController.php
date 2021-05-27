<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['changeSettings']));
        $this->registerMiddleware(new AuthMiddleware(['profileSettings']));
    }

    public function changeSettings(Request $request){
        $data = $request->getBody();
        $data["username"] = Application::$app->user->username;

        $data = json_encode($data);

//        echo $data;
//        exit;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/authentication/update.php");

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);
        $statusCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);

//        echo $result;
//        exit;

        if($statusCode == 200) {
            http_response_code(200);
            echo json_encode(array("message"=>"successful"));
            exit;
        }
        if($statusCode == 400)
        {
            http_response_code(400);
            echo $result;
            exit;
        }
        if($statusCode == 401)
        {
            http_response_code(401);
            echo $result;
            exit;
        }
        curl_close($curl);
    }

    public function profileSettings()
    {
        $styles = '<link rel="stylesheet" title="extended" type="text/css" href="styles/profile_settings.css"/>';
        $this->setLayout('general');
        $user =  Application::$app->user;
        return $this->render('profile_settings', "Profile Settings", $styles, ['model' => $user]);
    }
}