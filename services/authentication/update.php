<?php

require_once __DIR__ . '/../../vendor/autoloader.php';

use app\services\authentication\objects\User;
use app\services\utils\DatabaseConnection;

header("Access-Control-Allow-Origin: http://localhost:8000/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

const RULE_REQUIRED = 'required';
const RULE_MATCH = 'match';
const RULE_CORRECT ='correct';
const RULE_UNIQUE = 'unique';
const RULE_MIN = 'min';
const RULE_EMAIL ='email';

function getInformation(): array
{
    $data = json_decode(file_get_contents("php://input"));
    $values = $data;

    $receivedRules = ['currentPassword' => [RULE_REQUIRED,RULE_CORRECT],
                        'newPassword' => [RULE_REQUIRED,RULE_MIN],
                        'confirmPassword' => [RULE_REQUIRED,RULE_MATCH],
                        'email' => [RULE_EMAIL,RULE_UNIQUE]];

    return [$values, $receivedRules];
}

function validate($receivedRules, $values, $database): array
{
    $errors = [];
    foreach ($receivedRules as $attribute => $rules) {
        $value = isset($values->$attribute) ? $values->$attribute : '';
        foreach ($rules as $index => $rule) {
            $ruleName = $rule;
            if (!is_string($ruleName)) {
                $ruleName = $rule[0];
            }

            if ($ruleName === RULE_REQUIRED && !$value) {
                $errors[$attribute] = ['This field is required!'];
            }
            if ($ruleName === RULE_MIN && $value && strlen($value) < 8) {
                $errors[$attribute] = ['The minimum length is ' . 8];
            }
            if($ruleName === RULE_MATCH && isset($values->newPassword) &&  $value !== $values->newPassword)
            {
                $errors[$attribute] = ['Passwords do not match!'];
            }
            if($ruleName === RULE_CORRECT && $value && $value != $values->password){
                $errors[$attribute] = ['Wrong password'];
            }
            if ($ruleName === RULE_UNIQUE) {
                $uniqueAttr = $rule['attribute'] ?? $attribute;
                $tableName = 'users';
                $statement = $database->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                $statement->bindValue(':attr', $values->{$attribute});
                $statement->execute();
                $record = $statement->fetch();

                if (!empty($record)) {
                    $errors[$attribute] = ['This ' . $attribute .' already exists!'];
                }
            }
            if($ruleName === RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL))
            {
                $errors[$attribute] = ['Not a valid email!'];
            }
        }
    }
    return $errors;
}

function updateInformation($id,$values, $database): bool
{
    $tableName = 'users';
    $attributes = [];
    foreach ($values as $key => $value) {
        $attributes[] = $key;
    }

    $toInsert = [];
    foreach($attributes as $attribute)
    {
        $toInsert[] = $attribute . "= :$attribute";
    }
    $toInsert = implode(',',$toInsert);
    $statement = $database->pdo->prepare("UPDATE $tableName SET " . $toInsert . " WHERE id = :id");
    foreach ($attributes as $attribute) {
        $statement->bindValue(":$attribute", $values->{$attribute});
    }
    $statement->bindValue(":id",$id);

    $statement->execute();
    return true;
}

$received = getInformation();
$data = $received[0];
$rules = $received[1];

$database = DatabaseConnection::getDatabaseConnection();
$connection = $database->pdo;

$user = new User($connection);
$user = $user->userExists(["username"=>$data->username]);

if($user && password_verify($data->password,$user->password))
{

    if(!(isset($data->currentPassword) || isset($data->newPassword) || isset($data->confirmPassword)))
    {
        unset($rules["currentPassword"]);
        unset($rules["newPassword"]);
        unset($rules["confirmPassword"]);
        unset($data->password);
    }
    if(!(isset($data->email)) || $data->email === $user->email)
    {
        unset($rules["email"]);
    }

    $errors = validate($rules,$data,$database);
    if(!empty($errors))
    {
        http_response_code(400);
        echo json_encode(array("errors"=>$errors));
        exit;
    }

    unset($data->confirmPassword);
    unset($data->currentPassword);
    if(isset($data->newPassword)) {
        $data->password = password_hash($data->newPassword, PASSWORD_BCRYPT);;
    }
    unset($data->newPassword);
    updateInformation($user->id,$data,$database);

    http_response_code(200);
    echo json_encode(array("message"=>"Modified setting successfully"));
    exit;
}else{
    http_response_code(401);
    echo json_encode(array("errors"=>"Access forbidden"));
    exit;
}