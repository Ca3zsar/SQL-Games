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

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED,[self::RULE_UNIQUE, 'class' => self::class]],
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8]],
            'confirmPassword' => [self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password']]
        ];
    }

    public function updateSettings()
    {

    }

    public function tableName(): string
    {
        return 'users';
    }

    public function saveUser(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::saveUser();
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