<?php

require_once __DIR__ . '/../../vendor/autoloader.php';

use app\services\authentication\objects\User;
use app\services\utils\DatabaseConnection;
require 'config/settings.php';
include_once 'php-jwt-master/src/BeforeValidException.php';
include_once 'php-jwt-master/src/ExpiredException.php';
include_once 'php-jwt-master/src/SignatureInvalidException.php';
include_once 'php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: http://localhost:8000/");
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
    http_response_code(400);

    // display message: unable to create user
    echo json_encode(array("errors"=>$errors));
    exit;
}

$user = $user->userExists(["username"=>$data->username]);

if($user && password_verify($data->password,$user->password))
{
    $token = array(
        "iat" => JWT_ISSUED_AT,
        "exp" => JWT_EXPIRATION,
        "iss" => JWT_ISSUER,
        "data" => array(
            "id" => $user->id,
            "username" => $user->username,
            "email" => $user->email
        )
    );

    http_response_code(200);

    $jwt = JWT::encode($token, JWT_KEY);
    echo json_encode(
        array(
            "message" => "Successful login.",
            "jwt" => $jwt
        )
    );
}else{
    // set response code
    http_response_code(401);

    // tell the user login failed
    echo json_encode(array("errors" => ["Login failed."]));
}