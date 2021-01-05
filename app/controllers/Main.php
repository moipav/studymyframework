<?php
namespace app\controllers;

class Main
{
    public function __construct()
    {
        echo __CLASS__ . ' how mach is the fish';
    }

    public function indexAction()
    {
        echo __CLASS__ . ' ' . __METHOD__;
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