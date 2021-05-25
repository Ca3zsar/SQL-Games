<?php


namespace app\controllers;


use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SettingsController extends Controller
{

    public function changeSettings(Request $request){
        $data = $request->getBody();
        $data["username"] = Application::$app->user->username;
        $data["password"] = Application::$app->user->password;

        $data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/authentication/update.php");

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);
        curl_close($curl);

        Application::$app->response->redirect('/');
    }

    public function profileSettings()
    {
        $styles = '<link rel="stylesheet" title="extended" type="text/css" href="styles/profile_settings.css"/>';
        $this->setLayout('general');
        $user =  Application::$app->user;
        return $this->render('profile_settings', "Profile Settings", $styles, ['model' => $user]);
    }
}