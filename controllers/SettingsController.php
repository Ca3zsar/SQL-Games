<?php


namespace app\controllers;


use app\core\Application;
use app\core\Request;

class SettingsController extends \app\core\Controller
{

    public function changeSettings(Request $request){
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