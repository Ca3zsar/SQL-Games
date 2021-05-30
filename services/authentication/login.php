<?php

require_once __DIR__ . '/../../vendor/autoloader.php';

use app\services\authentication\objects\User;
use app\services\utils\DatabaseConnection;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

const RULE_REQUIRED = 'required';

function getInformation(): array
{
    $data = json_decode(file_get_contents("php://input"));
    $values = $data;

    $receivedRules = ['username' => [RULE_REQUIRED],
        'password' => [RULE_REQUIRED]];

    return [$values, $receivedRules];
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
if (empty($data->password)) {
    $errors['password'] = ['This field is required!'];
}

if(!empty($errors))
{
    // set response code
    http_response_code(401);

    // display message: unable to create user
    echo json_encode(array("errors"=>$errors));
    exit;
}

$user = $user->userExists(["username"=>$data->username]);

if($user && password_verify($data->password,$user->password))
{

    http_response_code(200);

    echo json_encode(
        array(
            "message" => "Successful login."
        )
    );
}else{
    // set response code
    http_response_code(401);

    // tell the user login failed
    $errors["loginError"] = ["Login failed"];
    echo json_encode(array("errors" => $errors));
}