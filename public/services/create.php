<?php

require_once __DIR__ . '/../../vendor/autoloader.php';

use \app\core\Database;
use app\core\DotEnv;

const RULE_REQUIRED = 'required';
const RULE_TITLE_UNIQUE = 'title-unique';
const RULE_MIN_TEXT = 'min-text';

function getDatabaseConnection()
{
    (new DotEnv(dirname(dirname(__DIR__)) . '/.env'))->load();
    $config = [
        'db' => [
            'dsn' => getenv('DB_DSN'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD')
        ]
    ];
    return new Database($config['db']);
}

function getInformation()
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $data = json_decode(file_get_contents("php://input"));
    $values = $data->values[0];
    $receivedRules = $data->rules[0];

    return [$values,$receivedRules];
}

function validate($receivedRules, $values,$database): array
{
    $errors=[];
    foreach ($receivedRules as $attribute => $rules) {
        $value = $values->$attribute;
        foreach ($rules as $index => $rule) {
            $ruleName = $rule;
            if (!is_string($ruleName)) {
                $ruleName = $rule[0];
            }
            if ($ruleName === RULE_REQUIRED && !$value) {
                $errors[$attribute] = 'This field is required!';
            }
            if ($ruleName === RULE_MIN_TEXT && strlen($value) < 20) {
                $errors[$attribute] = 'The minimum length is ' . 20;
            }
            if ($ruleName === RULE_TITLE_UNIQUE) {
                $uniqueAttr = $rule['attribute'] ?? $attribute;
                $tableName = 'exercises';
                $statement = $database->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                $statement->bindValue(':attr', $values->{$attribute});
                $statement->execute();
                $record = $statement->fetch();

                if (!empty($record)) {
                    $errors[$attribute] = 'This title already exists!';
                }
            }
        }
    }
    return $errors;
}

function addInformation($values,$database)
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

$information = getInformation();
$database = getDatabaseConnection();
$errors = validate($information[1],$information[0],$database);

if (!empty($errors)) {
    var_dump(json_encode($errors));
    return $errors;
    exit();
}

addInformation($information[0],$database);
return $errors;