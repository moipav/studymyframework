<?php


class Main
{
    public function __construct()
    {
        echo __CLASS__ . ' how mach is the fish';
    }

    public function index()
    {
        echo __CLASS__ . ' ' . __METHOD__;
    }
}