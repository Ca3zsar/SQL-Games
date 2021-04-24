<?php


namespace app\core\form;


use app\core\Model;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;
    public Model $model;
    public string $attribute;

    /**
     * Field constructor.
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString(): string
    {
        return sprintf('<input type="%s" placeholder="%s" name="%s" value="%s" class="user-input%s">
                    <div class="invalid-text">
                <p>%s</p>
            </div>',
            $this->type,ucfirst($this->attribute), $this->attribute, $this->model->{$this->attribute}, $this->model->hasError($this->attribute) ? ' invalid' : '',
            $this->model->getFirstError($this->attribute));
    }

    public function passwordField(): Field
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}