<?php


namespace app\core\form;


use app\core\Model;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_TEXT_AREA = 'text_area';
    public const TYPE_RADIO_BUTTON = 'radio';
    public const TYPE_SLIDER = 'range';

    public string $type;
    public Model $model;
    public string $attribute;
    public string $class;
    public string $options;

    /**
     * Field constructor.
     * @param Model $model
     * @param string $attribute
     * @param string $class
     */
    public function __construct(Model $model, string $attribute, string $class = "user-input", string $options = "")
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
        $this->class = $class;
        $this->options = $options;
    }

    public function __toString(): string
    {
        if ($this->type === self::TYPE_PASSWORD) {
            return sprintf('<input type="%s" placeholder="%s" name="%s" value="" class="%s%s">
                    <div class="invalid-text"><p>%s</p></div>',
                $this->type, ucfirst($this->attribute), $this->attribute, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '', $this->model->getFirstError($this->attribute));
        } elseif ($this->type === self::TYPE_TEXT_AREA) {
            return sprintf('<textarea name="%s" value="%s" class="%s%s" spellcheck="false"></textarea>
                    <div class="invalid-text"><p>%s</p></div>',
                $this->attribute, $this->model->{$this->attribute}, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '', $this->model->getFirstError($this->attribute));
        } elseif ($this->type === self::TYPE_RADIO_BUTTON || $this->type === self::TYPE_SLIDER) {
            return sprintf('<input type="%s" placeholder="%s" name="%s" %s class="%s%s">',
                $this->type, ucfirst($this->attribute), $this->attribute, $this->options, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '');
        } else {
            return sprintf('<input type="%s" placeholder="%s" name="%s" value="%s" class="%s%s">
                    <div class="invalid-text"><p>%s</p> </div>',
                $this->type, ucfirst($this->attribute), $this->attribute, $this->model->{$this->attribute}, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '',
                $this->model->getFirstError($this->attribute));
        }
    }

    public function passwordField(): Field
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function textArea(): Field
    {
        $this->type = self::TYPE_TEXT_AREA;
        return $this;
    }

    public function radioButton(): Field
    {
        $this->type = self::TYPE_RADIO_BUTTON;
        return $this;
    }

    public function slider(): Field
    {
        $this->type = self::TYPE_SLIDER;
        return $this;
    }
}