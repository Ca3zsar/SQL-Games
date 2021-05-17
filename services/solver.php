<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use \app\core\Database;
use \app\core\DotEnv;

function getQueryInformation()
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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

function getDifferences(Database $database,$query,$correctQuery)
{
    $query = trim($query);
    if(str_starts_with(strtolower($query),"select"))
    {
        try{
            $query = rtrim($query,';');
            $correctQuery = rtrim($correctQuery,';');

            $statement = $database->pdo->prepare("($query EXCEPT ($correctQuery)) UNION ALL ($correctQuery EXCEPT ($query))");
            $statement->execute();

            $results = $statement->fetch();
            if(!empty($results))
            {
                echo json_encode(array("status"=>"wrong"));
                exit;
            }else{
                echo json_encode(array("status"=>"correct"));
                exit;
            }
        }catch (PDOException)
        {
            echo json_encode(array("error"=>"Invalid query"));
            exit;
        }
    }else{
        echo json_encode(array("error"=>"Only MySQL queries are allowed"));
        exit;
    }
}

function checkQuery(Database $database, $query): bool|string
{
    $query = trim($query);
    $query = rtrim($query,';');
    if(str_starts_with(strtolower($query),"select"))
    {
        try{
            $statement = $database->pdo->prepare($query);
            $statement->execute();

            $results = $statement->fetchAll();
            return json_encode(array("status"=>"correct","results"=>$results));
        }catch(PDOException)
        {
            return json_encode(array("error"=>"Invalid MySQL statement!"));
        }
    }else{
        if($query === ""){
            return json_encode(array("error"=>"Empty query"));
        }
        return json_encode(array("error"=>"Invalid Query / No DML or DDL allowed"));
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $queries = getQueryInformation();
}