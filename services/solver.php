<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use \app\core\Database;
use app\services\utils\Checker as CheckerAlias;

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
            $query = str_replace('&#39;',"'",$query);
            $query = str_replace('&#39',"'",$query);

            $correctQuery = rtrim($correctQuery, ';');
            $correctQuery = str_replace('&#39;',"'",$correctQuery);
            $correctQuery = str_replace('&#39',"'",$correctQuery);

            $statement = $database->pdo->prepare($query);
            $statement->execute();

            $firstResults = $statement->fetchAll(PDO::FETCH_ASSOC);
            $firstColumns = array();
            if(!empty($firstResults)) {
                $firstColumns = array_keys($firstResults[0]);
            }
            $statement = $database->pdo->prepare($correctQuery);
            $statement->execute();

            $secondResults = $statement->fetchAll(PDO::FETCH_ASSOC);
            $secondColumns = array();
            if(!empty($secondResults)) {
                $secondColumns = array_keys($secondResults[0]);
            }

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

            $statement = $database->pdo->prepare("((SELECT * FROM ( $query ) a )
                                                    EXCEPT 
                                                    ( SELECT * FROM ($correctQuery) b ) ) 
                                                    UNION ALL 
                                                    ((SELECT * FROM ( $correctQuery ) c ) 
                                                    EXCEPT 
                                                    (SELECT * FROM ( $query ) d ))");
            $statement->execute();

            $results = $statement->fetch();
            if (!empty($results)) {
                echo json_encode(array("status" => "wrong"));
                exit;
            } else {
                echo json_encode(array("status" => "correct"));
                exit;
            }
        } catch (PDOException $e) {
            echo json_encode(array("errorMessage" => $e->getMessage()));
            exit;
        }
    } else {
        echo json_encode(array("errorMessage" => "Only MySQL queries are allowed!"));
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
