<?php


namespace app\models;


use app\core\DBModel;
use app\core\Model;

class User extends DBModel
{
    public string $username= '';
    public string $email= '';
    public string $password= '';
    public string $confirmPassword= '';

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8]],
            'confirmPassword' => [self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password']]
        ];
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function attributes(): array
    {
        return ['username','email','password'];
    }
}