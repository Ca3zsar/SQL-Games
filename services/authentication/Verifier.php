<?php


namespace app\services\authentication;


use app\services\authentication\objects\User;
use app\services\utils\DatabaseConnection;

class Verifier
{
    public static function checkLoginStatus($username, $password): bool
    {
        $database = DatabaseConnection::getDatabaseConnection();
        $connection = $database->pdo;

        $user = new User($connection);
        $user = $user->userExists(["username"=>$username]);

        return $user && ($password === $user->password  || password_verify($password,$user->password));
    }
}