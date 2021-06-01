<?php


namespace app\core;


abstract class Model
{

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

    public function addError(string $attribute, string $message){
        $this->errors[$attribute][] = $message;
        return false;
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