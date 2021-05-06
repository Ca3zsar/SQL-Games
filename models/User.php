<?php


namespace app\models;


use app\core\DBModel;

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

    public function primaryKey(): string
    {
        return 'id';
    }
}