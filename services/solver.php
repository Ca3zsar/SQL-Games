<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use \app\core\Database;
use \app\core\DotEnv;
use JetBrains\PhpStorm\NoReturn;

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

function getQueryDatabaseConnection(): Database
{
    (new DotEnv(__DIR__ . '/.env.user'))->load();
    $config = [
        'db' => [
            'dsn' => getenv('DB_DSN_QUERY'),
            'user' => getenv('DB_USER_QUERY'),
            'password' => getenv('DB_PASSWORD_QUERY')
        ]
    ];
    return new Database($config['db']);
}

function getDifferences(Database $database, $query, $correctQuery)
{
    $query = trim($query);
    if (str_starts_with(strtolower($query), "select")) {
        try {
            $query = rtrim($query, ';');
            $correctQuery = rtrim($correctQuery, ';');

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

#[NoReturn] function sendData($information)
{
    echo json_encode($information);
    exit;
}

function checkQuery(Database $database, $query, $inService = true)
{
    $query = trim($query);
    $query = rtrim($query, ';');
    if (str_starts_with(strtolower($query), "select")) {
        try {
            $statement = $database->pdo->prepare($query);
            $statement->execute();

            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            if ($inService) {
                return json_encode(array("status" => "correct", "results" => $results));
            } else {
                sendData($results);
            }
        } catch (PDOException) {
            if ($inService) {
                return json_encode(array("errorMessage" => "Invalid MySQL statement!"));
            } else {
                echo json_encode(array("errorMessage" => "Invalid MySQL statement!"));
                exit;
            }
        }
    } else {
        if ($query === "") {
            if ($inService) {
                return json_encode(array("errorMessage" => "Empty query"));
            } else {
                echo json_encode(array("errorMessage" => "Empty query"));
                exit;
            }
        }
        if ($inService) {
            return json_encode(array("errorMessage" => "Invalid Query / No DML or DDL allowed"));
        } else {
            echo json_encode(array("errorMessage" => "Invalid Query / No DML or DDL allowed"));
            exit;
        }
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $queries = getQueryInformation();
    if(isset($queries->query))
    {
        getDifferences(getQueryDatabaseConnection(),$queries->query,$queries->correctQuery);
    }else{
        if(isset($queries->correctQuery))
        {
            checkQuery(getQueryDatabaseConnection(),$queries->correctQuery,false);
        }
    }
}

//echo checkQuery(getQueryDatabaseConnection(), 'select * from studenti where bursa > 400');