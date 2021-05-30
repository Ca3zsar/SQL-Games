<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use \app\services\utils\DatabaseConnection;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $params = substr($_SERVER['REQUEST_URI'], strlen("/get_exercises.php")); // '\x20\x2f'
    $pos = strpos($params, '/');

    if ($pos !== false) {
        $param = substr($params, $pos + 1);
    }

    $database = DatabaseConnection::getDatabaseConnection();
    if (empty($param) || $param[0] === '?') {
        $tableName = 'exercises';

        $diff = '';
        $search = '';
        if(isset($_GET["difficulty"]))
        {
            $diff = sprintf("WHERE difficulty =  '%s'", $_GET["difficulty"]);
            if(isset($_GET["search"]))
            {
                $diff = sprintf("%s AND title LIKE '%%%s%%' ",$diff,$_GET["search"]);
//                $diff .= " AND title LIKE CONCAT('%', ' $search ', '%')";
            }
        }else{
            if(isset($_GET["search"]))
            {
                $diff = sprintf("WHERE title LIKE '%%%s%%' ", $_GET["search"]);
            }
        }

        $orderBy = '';
        if(isset($_GET["orderBy"]))
        {
            if($_GET["orderBy"] === 'dateAdded')
            {
                $orderBy = "ORDER BY " . "createdAt";
            }
            if($_GET["orderBy"] === 'popularity')
            {
                $orderBy = "ORDER BY " . "timesSolved/(DATEDIFF(CURDATE(),createdAt)+1) DESC";
            }
        }

        $statement = $database->prepare("SELECT * FROM " . $tableName . ' ' . $diff . ' ' . $orderBy);
        $statement->execute();
        $record = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($record as &$row){
            unset($row["correctQuery"]);
        }

        if (!empty($record)) {
            echo json_encode($record);
            exit();
        }
    } elseif ($param != '' && !str_contains($param, '/')) {

        $tableName = 'exercises';

        if (is_numeric($param) && !str_contains($param, '.')) {
            $statement = $database->prepare("SELECT * FROM $tableName WHERE id = :id");
            $statement->bindValue(':id', $param);
            $statement->execute();
            $record = $statement->fetch(PDO::FETCH_ASSOC);
            unset($record["correctQuery"]);

            if (!empty($record)) {
                echo json_encode($record);
                exit();
            } else {
                http_response_code(404);
                echo json_encode(array("error" => "There is no exercise with that id"));
            }
        }
        elseif ($param === 'easy' || $param === 'medium' || $param === 'hard') {
            $statement = $database->prepare("SELECT * FROM $tableName WHERE difficulty = :difficulty");
            $statement->bindValue(':difficulty', $param);
            $statement->execute();
            $record = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($record as &$row){
                unset($row["correctQuery"]);
            }

            echo json_encode($record);
            exit();
        }
        else {
            http_response_code(400); // bad request
            echo json_encode(array("error" => "Invalid request."));
        }
    } else {
        http_response_code(400);// bad request
        echo json_encode(array("error" => "Invalid request. Too many arguments"));
    }
}