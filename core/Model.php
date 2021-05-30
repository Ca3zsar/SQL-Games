<?php


namespace app\core;


abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public const RULE_TITLE_UNIQUE = 'title-unique';
    public const RULE_MIN_TEXT = 'min-text';

    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value)
        {
            if(property_exists($this,$key))
            {
                $this->{$key} = $value;
            }
        }
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach($params as $key => $value)
        {
            $message = str_replace("{{$key}}",$value,$message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message){
        $this->errors[$attribute][] = $message;
        return false;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be a valid email address',
            self::RULE_MIN => 'Minimum length of the password must be {min}',
            self::RULE_MATCH => 'The passwords are not the same',
            self::RULE_UNIQUE => 'User with this {field} already exists',
            self::RULE_TITLE_UNIQUE => 'There is another exercise with this title',
            self::RULE_MIN_TEXT => 'Minimum length is not satisfied ( {min} )'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}