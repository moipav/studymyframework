<?php
error_reporting(-1);
use vendor\core\Router;

//require_once '../vendor/core/Router.php';
require_once '../vendor/libs/functions.php';
//require_once '../app/controllers/Main.php';
//require_once '../app/controllers/Posts.php';
//require_once '../app/controllers/PostsNew.php';
//сделаем простую автозагрузку
define('WWW', __DIR__);
define('CORE', dirname((__DIR__) . 'vendor/core'));
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');

spl_autoload_register(function ($class){
    $file = ROOT . '/' . str_replace('\\','/', $class). '.php';
//    echo $file;

    if(is_file($file)){
        require_once $file;
    }
});

$query = rtrim($_SERVER['QUERY_STRING'], '/');
//собственные правила создаются выше, чтобы они были приоритетнее
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller'=>'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller'=>'Page', 'action' => 'view']);

//маршрутизацию по умолначию  делаем при помощи регулярных выражений
Router::add('^$', ['controller'=>'Main', 'action'=>'index']);//сответствует пустой строке
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');//свободно вводимые данные будут обрабатываться в Router и проверяться на соответствие


/*
if(Router::machRoute($query)){
    debug(Router::getRoute());
}else{
    echo '404';
}*/
Router::dispath($query);