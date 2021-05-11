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

    abstract public function rules() : array;

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules)
        {
            $value = $this->{$attribute};
            foreach ($rules as $rule)
            {
                $ruleName = $rule;
                if (!is_string($ruleName))
                {
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    $this->addErrorForRule($attribute,self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL))
                {
                    $this->addErrorForRule($attribute,self::RULE_EMAIL);
                }
                if(($ruleName === self::RULE_MIN || $ruleName === self::RULE_MIN_TEXT) && strlen($value) < $rule['min']){
                    if($ruleName === self::RULE_MIN)
                    {
                        $this->addErrorForRule($attribute,self::RULE_MIN, $rule);
                    }
                    else {
                        $this->addErrorForRule($attribute, self::RULE_MIN_TEXT, $rule);
                    }
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                {
                    $this->addErrorForRule($attribute,self::RULE_MATCH);
                }
                if($ruleName === self::RULE_UNIQUE || $ruleName === self::RULE_TITLE_UNIQUE){
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(':attr', $value);
                    $statement->execute();
                    $record = $statement->fetch();
                    if($record){
                        if($ruleName === self::RULE_UNIQUE){
                            $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                        }else {
                            $this->addErrorForRule($attribute, self::RULE_TITLE_UNIQUE, ['field' => $attribute]);
                        }
                    }
                }
            }
        }

        return empty($this->errors);
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