<?php

use app\services\authentication\objects\User;
use app\services\utils\DatabaseConnection;

require_once __DIR__ . '/../../vendor/autoloader.php';

header("Access-Control-Allow-Origin: http://localhost:8000/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

const RULE_REQUIRED = 'required';
const RULE_UNIQUE = 'title-unique';
const RULE_MIN = 'min-text';
const RULE_MATCH = 'match';
const RULE_EMAIL = 'email';

function getInformation(): array
{
    $data = json_decode(file_get_contents("php://input"));
    $values = $data;

    $receivedRules = ['username' => [RULE_REQUIRED, RULE_UNIQUE],
        'email' => [RULE_REQUIRED, RULE_EMAIL, RULE_UNIQUE],
        'password' => [RULE_REQUIRED, RULE_MIN],
        'confirmPassword' => [RULE_REQUIRED, RULE_MATCH]];

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

            if ($ruleName === RULE_REQUIRED && !$value) {
                $errors[$attribute] = ['This field is required!'];
            }
            if ($ruleName === RULE_MIN && strlen($value) < 8) {
                $errors[$attribute] = ['The minimum length is ' . 8];
            }
            if($ruleName === RULE_MATCH && $value !== $values->password)
            {
                $errors[$attribute] = ['Passwords do not match!'];
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

$database = DatabaseConnection::getDatabaseConnection();
$connection = $database->pdo;

$user = new User($connection);

$received = getInformation();
$data = $received[0];
$rules = $received[1];

if (empty($data->username)) {
    $errors['username'] = ['This field is required!'];
}
if (empty($data->email)) {
    $errors['email'] = ['This field is required!'];
}
if (empty($data->password)) {
    $errors['password'] = ['This field is required!'];
}
if (empty($data->confirmPassword)) {
    $errors['confirmPassword'] = ['This field is required!'];
}

if(!empty($errors))
{
    // set response code
    http_response_code(400);

    // display message: unable to create user
    echo json_encode(array("errors"=>$errors));
    exit;
}

    $errors = validate($rules,$data,$database);

if(!empty($errors))
{
    // set response code
    http_response_code(400);

    // display message: unable to create user
    echo json_encode(array("errors"=>$errors));
    exit;
}

// set product property values
$user->username = $data->username;
$user->email = $data->email;
$user->password = $data->password;

if($user->create()){
    // set response code
    http_response_code(200);

    // display message: user was created
    echo json_encode(array("message" => "User was created."));
    exit;
}
else{
    http_response_code(400);
    echo json_encode(array("errors" => ["Unable to create user."]));
    exit;
}

