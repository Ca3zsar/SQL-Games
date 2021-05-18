<?php


namespace app\services;


use app\core\Database;
use app\core\DotEnv;
use PDO;
use PDOException;

class Checker
{
    static function getQueryDatabaseConnection(): Database
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

    static function sendData($information)
    {
        echo json_encode($information);
        exit;
    }

    static function checkQuery(Database $database, $query, $inService = true)
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
                    Checker::sendData($results);
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
}