<?php

namespace app\controllers;
use vendor\core\base\Controller;
class Posts extends Controller
{

    public function indexAction ()
    {
        echo __CLASS__ . ' !!!' . __METHOD__;
    }

    public function testAction()
    {
        echo  __METHOD__;
    }

    public function testPageAction()
    {
       echo  __METHOD__;
    }

}