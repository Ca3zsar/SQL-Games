<?php


namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;

use PDO;

class ShopController extends Controller
{
    public $exercises;

    public function exercises()
    {
        Application::$app->response->redirect('/shop');
    }

    public function checkStatus($id_user, $id_exercise)
    {
        $tableName = 'userexercises';
        $statement = Application::$app->db->prepare("SELECT solved FROM $tableName WHERE idUser = :idUser and idExercise = :idExercise");
        $statement->bindValue(':idUser', $id_user);
        $statement->bindValue(':idExercise', $id_exercise);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($record)) {
            return $record["solved"];
        } else {
            return -1;
        }
    }

    public function getAuthorName($id_author)
    {
        $tableName = 'users';
        $statement = Application::$app->db->prepare("SELECT username FROM $tableName WHERE id = :idUser");
        $statement->bindValue(':idUser', $id_author);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($record)) {
            return $record["username"];
        } else {
            return -1;
        }
    }

    public function loadExercises()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, "http://localhost:8201/exercises.php");

        $result = curl_exec($curl);
        $result = json_decode($result);

        $newResults = [];

        $user_id = Application::$app->session->get('user');
        foreach($result as $row)
        {
            $row->solved = $this->checkStatus($user_id,$row->id);

            $row->authorName = $this->getAuthorName($row->authorId);
            unset($row->{'authorId'});

            $newResults[] = $row;
        }

        curl_close($curl);
        echo json_encode($newResults);
    }

    public function shop(Request $request, Response $response)
    {
        $styles = '<link rel="stylesheet" title="extended" type="text/css" href="styles/shop.css"/>
        <link rel="stylesheet" title="compact" type="text/css" href="styles/compact-shop.css" />';

        $this->setLayout('general');
        return $this->render('shop', "SQL-Games Shop", $styles);
    }

}