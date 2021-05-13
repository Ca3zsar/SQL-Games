<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;

class ShopController extends Controller
{
    public $exercises;

    public function exercises()
    {
        Application::$app->response->redirect('/shop');
    }

    public function loadExercises()
    {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_POST,0);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/exercises.php");

        $result = curl_exec($curl);
        curl_close($curl);
        echo $result;
    }

    public function shop(Request $request, Response $response)
    {
        $styles = '<link rel="stylesheet" title="extended" type="text/css" href="styles/shop.css"/>
        <link rel="stylesheet" title="compact" type="text/css" href="styles/compact-shop.css" />';

        $this->setLayout('general');
        return $this->render('shop', "SQL-Games Shop", $styles);
    }

}