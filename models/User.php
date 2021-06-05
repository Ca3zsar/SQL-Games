<?php


namespace app\models;

use app\core\Application;
use app\core\DBModel;
use PDO;

class User extends DBModel
{
    public string $username= '';
    public string $email= '';
    public string $password= '';
    public string $confirmPassword= '';
    public string $loginError;
    public int $coins;
    public int $id;

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['username','email','password'];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function updateCoins($toSubtract)
    {
        $tableName = "users";
        $statement = $statement = Application::$app->db->prepare("UPDATE $tableName SET coins = $this->coins-$toSubtract WHERE id= $this->id");
        $statement->execute();
    }

    static function getUsername($id)
    {
        $tableName = "users";
        $statement = Application::$app->db->prepare("select username from $tableName where id=:id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC)["username"];
    }
}