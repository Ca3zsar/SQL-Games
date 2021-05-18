<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use \app\core\Database;
use app\services\Checker as CheckerAlias;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Expose-Headers : Content-Disposition, FileName");
header("Access-Control-Allow-Headers: Data-Type,Access-Control-Expose-Headers, FileName, Origin, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function getQueryInformation()
{
    return json_decode(file_get_contents("php://input"));
}

function getDifferences(Database $database, $query, $correctQuery)
{
    $query = trim($query);
    if (str_starts_with(strtolower($query), "select")) {
        try {
            $query = rtrim($query, ';');
            $correctQuery = rtrim($correctQuery, ';');

            $statement = $database->pdo->prepare($query);
            $statement->execute();

            $firstResults = $statement->fetchAll(PDO::FETCH_ASSOC);
            $firstColumns = array_keys($firstResults[0]);

            $statement = $database->pdo->prepare($correctQuery);
            $statement->execute();

            $secondResults = $statement->fetchAll(PDO::FETCH_ASSOC);
            $secondColumns = array_keys($secondResults[0]);

            if(sizeof($firstColumns) != sizeof($secondColumns))
            {
                echo json_encode(array("status"=>"wrong"));
                exit;
            }

            if(sizeof(array_diff($firstColumns,$secondColumns)) + sizeof(array_diff($secondColumns,$firstColumns)) > 0)
            {
                echo json_encode(array("status"=>"wrong"));
                exit;
            }

            $statement = $database->pdo->prepare("($query EXCEPT ($correctQuery)) UNION ALL ($correctQuery EXCEPT ($query))");
            $statement->execute();

            $results = $statement->fetch();
            if (!empty($results)) {
                echo json_encode(array("status" => "wrong"));
                exit;
            } else {
                echo json_encode(array("status" => "correct"));
                exit;
            }
        } catch (PDOException) {
            echo json_encode(array("errorMessage" => "Invalid query"));
            exit;
        }
    } else {
        echo json_encode(array("errorMessage" => "Only MySQL queries are allowed"));
        exit;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $queries = getQueryInformation();
    if(isset($queries->query))
    {
        getDifferences(CheckerAlias::getQueryDatabaseConnection(),$queries->query,$queries->correctQuery);
    }else{
        if(isset($queries->correctQuery))
        {
            CheckerAlias::checkQuery(CheckerAlias::getQueryDatabaseConnection(),$queries->correctQuery,false);
        }
    }
}

//echo checkQuery(getQueryDatabaseConnection(), 'select * from studenti where bursa > 400');