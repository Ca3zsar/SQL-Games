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
    public const TYPE_TEL = 'tel';
    public const TYPE_DATE = 'date';
    public const TYPE_ERROR = 'error';

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
            return sprintf('<input type="%s" placeholder="%s" name="%s" value="" class="%s%s" %s>',
                $this->type, ucfirst($this->attribute), $this->attribute, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '', $this->options);
        } elseif ($this->type === self::TYPE_TEXT_AREA) {
            return sprintf('<textarea name="%s" class="%s%s" spellcheck="false" %s>%s</textarea>',
                $this->attribute, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '',$this->options, $this->model->{$this->attribute});
        } elseif ($this->type === self::TYPE_RADIO_BUTTON || $this->type === self::TYPE_SLIDER) {
            return sprintf('<input type="%s" placeholder="%s" name="%s" %s class="%s%s">',
                $this->type, ucfirst($this->attribute), $this->attribute, $this->options, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '');
        } elseif ($this->type === self::TYPE_DATE) {
            return sprintf('<input type="%s" name="%s" value="%s" %s class="%s%s">
                    <div class="invalid-text %s"><p>%s</p> </div>',
                $this->type, $this->attribute, $this->model->{$this->attribute}, $this->options, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '', $this->attribute,
                $this->model->getFirstError($this->attribute));
        } elseif ($this->type === self::TYPE_TEXT) {
            return sprintf('<input type="%s" placeholder="%s" name="%s" value="%s" %s class="%s%s"/>',
                $this->type, ucfirst($this->attribute), $this->attribute, $this->model->{$this->attribute}, $this->options, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '');
        } elseif($this->type === self::TYPE_TEL){
            return sprintf('<input type="%s" placeholder="%s" name="%s" value="%s" %s class="%s%s">
                    <div class="invalid-text %s"><p>%s</p> </div>',
                $this->type, ucfirst($this->attribute), $this->attribute, $this->model->{$this->attribute}, $this->options, $this->class, $this->model->hasError($this->attribute) ? ' invalid' : '', $this->attribute,
                $this->model->getFirstError($this->attribute));
        }
        else {
            return sprintf('<div class="invalid-text %s"><p>%s</p> </div>',$this->attribute,
                $this->model->getFirstError($this->attribute));
        }
    }

    public function errorField() : Field
    {
        $this->type = self::TYPE_ERROR;
        return $this;
    }

    public function passwordField(): Field
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function telField(): Field
    {
        $this->type = self::TYPE_TEL;
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

    public function dateField(): Field
    {
        $this->type = self::TYPE_DATE;
        return $this;
    }


    public function slider(): Field
    {
        $this->type = self::TYPE_SLIDER;
        return $this;
    }
}