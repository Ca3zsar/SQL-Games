<?php


namespace app\core\form;


use app\core\Model;

class Form
{
    public static function begin($action,$method)
    {
        echo sprintf('<form id="complete-form" class="complete-form" action="%s" method="%s">',$action,$method);
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