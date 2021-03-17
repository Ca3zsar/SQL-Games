<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class SiteController extends Controller
{
    public function handleContact(Request $request)
    {
        $body = $request->getBody();
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