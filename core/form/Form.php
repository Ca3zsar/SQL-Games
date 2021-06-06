<?php


namespace app\core\form;


use app\core\Model;

class Form
{
    public static function begin($method)
    {
        echo sprintf('<form class="complete-form" method="%s">',$method);
        return new Form();
    }

    public static function end()
    {
        echo'</form>';
    }

    public function field(Model $model, $attribute,$class="user-input",$options="")
    {
        return new Field($model,$attribute,$class,$options);
    }
}