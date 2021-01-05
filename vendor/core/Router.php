<?php

namespace vendor\core;

class Router
{


    protected static $routes = [];//массив всех маршрутов
    protected static $route = [];//текущий маршрут

    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }
/**проверяет переданные данные по шаблону $pattern
 * и разделяет их на controllers AND actions
 *
 * */

    public static function  machRoute($url)
    {
        foreach (self::$routes as $pattern => $route){
            if(preg_match("#$pattern#i", $url, $matches)){
                debug(self::$routes);
                debug($route);
                foreach ($matches as $k => $v){
                    if(is_string($k)){
                        $route[$k]=$v;
                    }
                }
                if(!isset($route['action'])){
                    $route['action'] = 'index';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /***
     *перенаправляет URL по корректному маршруту
     * @param string $url входящий URL
     * @return void
     */
    //необходимо проверить пути и отфильтровать не правильные запросы
    //если mathRoute успешно отработает все ок иначе 404
    public static function dispath($url)
    {
        $url = self::removeQueryString($url);
      //  var_dump($url);
        if(self::machRoute($url)){
            $controller = 'app\\controllers\\'. self::upperCamelCase(self::$route['controller']);
            if(class_exists($controller)){
                //debug(self::$route);
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) .'Action';
                if(method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                }else{
                    echo "Метод <b>$controller::$action</b> не найден";
                }
            }else{
                echo "Контроллер $controller не найден";
                http_response_code(404);
                include '404.html';
            }
        }
    }

    /**
     * @param $name string
     * принимает контроллер и приводит его к нужному виду
     */
    protected static function upperCamelCase($name)
    {
        $name = str_replace('-',' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return $name;
    }

    protected static function removeQueryString($url)
    {
        if($url){
            $params = explode('&', $url, 2);
            if(false === strpos($params[0], '=')){
                return rtrim($params[0], '/');
            }else{
                return '';
            }

        }

        return $url;
    }

    protected static function lowerCamelCase($name)
    {
        return $name = lcfirst(self::upperCamelCase($name));
    }
    /**для тестирования
     * проверить таплицу маршрутов
     * @return array
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**проверим текущий маршрут
     * @return array
     */
    public static function getRoute()
    {
        return self::$route;
    }
}