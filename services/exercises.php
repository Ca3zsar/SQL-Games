<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use \app\core\Database;
use \app\core\DotEnv;

const RULE_REQUIRED = 'required';
const RULE_TITLE_UNIQUE = 'title-unique';
const RULE_MIN_TEXT = 'min-text';
const RULE_INT = 'int';
const RULE_CORRECT = 'correct';
const RULE_DIFFICULTY = "difficulty";

function getDatabaseConnection(): Database
{
    (new DotEnv(__DIR__ . '/.env'))->load();
    $config = [
        'db' => [
            'dsn' => getenv('DB_DSN'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD')
        ]
    ];
    return new Database($config['db']);
}

function getInformation(): array
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $data = json_decode(file_get_contents("php://input"));
    $values = $data;

    $receivedRules = ["difficulty" => [RULE_REQUIRED, RULE_DIFFICULTY],
        "title" => [RULE_REQUIRED, RULE_TITLE_UNIQUE],
        "price" => [RULE_REQUIRED, RULE_INT],
        "requirement" => [RULE_REQUIRED, RULE_MIN_TEXT],
        "correctQuery" => [RULE_REQUIRED, RULE_CORRECT]];

    return [$values, $receivedRules];
}

function validate($receivedRules, $values, $database): array
{
    $errors = [];
    foreach ($receivedRules as $attribute => $rules) {
        $value = $values->$attribute;
        foreach ($rules as $index => $rule) {
            $ruleName = $rule;
            if (!is_string($ruleName)) {
                $ruleName = $rule[0];
            }
            if ($ruleName === RULE_INT) {
                if (!(is_numeric($value) && !str_contains($value, '.'))) {
                    $errors[$attribute] = ['This field has to be an integer!'];
                }
            }
            if ($ruleName === RULE_DIFFICULTY) {
                if (!in_array($value, ['easy', 'medium', 'hard'])) {
                    $errors[$attribute] = ['Invalid difficulty!'];
                }
            }
            if ($ruleName === RULE_CORRECT) {
                continue;
            }
            if ($ruleName === RULE_REQUIRED && !$value) {
                if ($attribute != 'correctQuery') {
                    $errors[$attribute] = ['This field is required!'];
                }
            }
            if ($ruleName === RULE_MIN_TEXT && strlen($value) < 20) {
                $errors[$attribute] = ['The minimum length is ' . 20];
            }
            if ($ruleName === RULE_TITLE_UNIQUE) {
                $uniqueAttr = $rule['attribute'] ?? $attribute;
                $tableName = 'exercises';
                $statement = $database->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                $statement->bindValue(':attr', $values->{$attribute});
                $statement->execute();
                $record = $statement->fetch();

                if (!empty($record)) {
                    $errors[$attribute] = ['This title already exists!'];
                }
            }
        }
    }
    return $errors;
}

function addInformation($values, $database): bool
{
    $tableName = 'exercises';
    $attributes = [];
    foreach ($values as $key => $value) {
        $attributes[] = $key;
    }
    $params = array_map(fn($attribute) => ":$attribute", $attributes);
    $statement = $database->pdo->prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(',', $params) . ")");
    foreach ($attributes as $attribute) {
        $statement->bindValue(":$attribute", $values->{$attribute});
    }

    $statement->execute();
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $information = getInformation();

    if (empty($information[0]->price)) {
        $errors['price'] = ['This field is required!'];
    }
    if (empty($information[0]->requirement)) {
        $errors['requirement'] = ['This field is required!'];
    }
    if (empty($information[0]->title)) {
        $errors['title'] = ['This field is required!'];
    }
    if (empty($information[0]->difficulty)) {
        $errors['difficulty'] = ['This field is required!'];
    }

    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/json');

    if (!empty($errors)) {
        echo json_encode(array("errors" => $errors));
        exit();
    }

    $database = getDatabaseConnection();
    $errors = validate($information[1], $information[0], $database);

    if (!empty($errors)) {
        echo json_encode(array("errors" => $errors));
        exit();
    }

    addInformation($information[0], $database);
    echo json_encode(array("errors" => $errors));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $params = explode('/', trim($_SERVER['REQUEST_URI'], '/exercises.php')); // '\x20\x2f'
    $database = getDatabaseConnection();

    if (trim($_SERVER['REQUEST_URI'], '/exercises.php') === '' || $params[0] == '') {
        $tableName = 'exercises';
        $statement = $database->prepare("SELECT * FROM $tableName");
        $statement->execute();
        $record = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($record)) {
            echo json_encode($record);
            exit();
        }
    } elseif (sizeof($params) === 1 && $params[0] != '') {
        $param = $params[0];
        if (is_numeric($param) && !str_contains($param, '.')) {
            $tableName = 'exercises';
            $statement = $database->prepare("SELECT * FROM $tableName WHERE id = :id");
            $statement->bindValue(':id', $param);
            $statement->execute();
            $record = $statement->fetch(PDO::FETCH_ASSOC);

            if (!empty($record)) {
                echo json_encode($record);
                exit();
            } else {
                http_response_code(404);
                echo json_encode(array("error" => "There is no exercise with that id"));
            }
        } else {
            http_response_code(400); // bad request
            echo json_encode(array("error" => "Invalid request. Invalid ID provided"));
        }
    } else {
        http_response_code(400);// bad request
        echo json_encode(array("error" => "Invalid request. Too many arguments"));
    }
}


