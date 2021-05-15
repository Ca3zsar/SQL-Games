<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

use app\models\Exercise;
use PDO;

class ShopController extends Controller
{
    public function exercises()
    {
        Application::$app->response->redirect('/shop');
    }


    public function loadExercises($currentPage)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $params = array();
        if (isset($_GET["orderBy"])) {
            $params["orderBy"] = $_GET["orderBy"];
//            $orderBy = "?orderBy=".$_GET["orderBy"];
        }

//        $difficulty = '';
        if (isset($_GET["difficulty"])) {
            $params["difficulty"] = $_GET["difficulty"];
//            $difficulty = "difficulty=".$_GET["difficulty"];
        }
        $query = http_build_query($params);
        $url = "http://localhost:8201/exercises.php";

        if (!empty($query)) {
            $url = $url . "?" . $query;
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        $result = curl_exec($curl);
        $result = json_decode($result);

        $limit = 3;
        $offset = ($currentPage - 1) * $limit;
        if($result) {
            $result = array_slice($result, $offset, $limit);
        }
        $newResults = [];

        $user_id = Application::$app->session->get('user');
        foreach ($result as $row) {
            $row->solved = Exercise::checkStatus($user_id, $row->id);

            if (isset($_SESSION['user'])) {
                if ($row->solved === -1) {
                    if (Application::$app->user->coins < $row->price) {
                        $row->solved = -2;
                    }
                }
            }
            $row->authorName = Exercise::getAuthorName($row->authorId);

            $newResults[] = $row;
        }

        curl_close($curl);
        echo json_encode($newResults);
    }

    public function shop(Request $request)
    {
        $styles = '<link rel="stylesheet" title="extended" type="text/css" href="styles/shop.css"/>
        <link rel="stylesheet" title="compact" type="text/css" href="styles/compact-shop.css" />';

        if ($request->isGet() && isset($_GET["page"]) && isset($_GET["fromJS"])) {
            $this->loadExercises($_GET["page"]);
            return;
        }

        $this->setLayout('general');
        return $this->render('shop', "SQL-Games Shop", $styles);
    }

}