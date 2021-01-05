<?php

require_once '../vendor/core/Router.php';
require_once '../vendor/libs/functions.php';

$query = rtrim($_SERVER['QUERY_STRING'], '/');
/*
Router::add('posts/add', ['controller'=>'Posts', 'action'=>'add']);
Router::add('posts', ['controller'=>'Posts', 'action'=>'index']);
Router::add('', ['controller'=>'Main', 'action'=>'index']);*/

//маршрутизацию по умолначию  делаем при помощи регулярных выражений
Router::add('^$', ['controller'=>'Main', 'action'=>'index']);//сответствует пустой строке
Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)?$');//свободно вводимые данные будут обрабатываться в Router и проверяться на соответствие
debug(Router::getRoutes());

/*
if(Router::machRoute($query)){
    debug(Router::getRoute());
}else{
    echo '404';
}*/
Router::dispath($query);