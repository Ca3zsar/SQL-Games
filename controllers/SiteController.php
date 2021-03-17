<?php

namespace app\controllers;

use app\core\Controller;

class SiteController extends Controller
{
    public function handleContact()
    {
        return 'Handling submitted data';
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function home()
    {
        $params = [
            'name' => "SQL-Games"
        ];
        return $this->render('home',$params);
    }
}