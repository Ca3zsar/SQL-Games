<?php


namespace app\controllers;


use app\core\Controller;

class ShopController extends Controller
{
    public function shop()
    {
        $styles = '<link rel="stylesheet" title="extended" type="text/css" href="styles/shop.css"/>
        <link rel="stylesheet" title="compact" type="text/css" href="styles/compact-shop.css" />';

        $this->setLayout('general');
        return $this->render('shop',"SQL-Games Shop",$styles);
    }
}