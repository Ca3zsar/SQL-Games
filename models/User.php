<?php


namespace app\models;


use app\core\DBModel;
use app\core\Model;

class User extends DBModel
{
    public string $name= '';
    public string $email= '';
    public string $password= '';
    public string $confirmPassword= '';

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8]],
            'confirmPassword' => [self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password']]
        ];
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function register()
    {
        echo "Creating new user";
    }
}