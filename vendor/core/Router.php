<?php


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

                foreach ($matches as $k => $v){
                    if(is_string($k)){
                        $route[$k]=$v;
                    }
                }
                if(!isset($route['action'])){
                    $route['action'] = 'index';
                }
                debug($route);
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
        if(self::machRoute($url)){
            $controller = self::upperCamelCase(self::$route['controller']);
            if(class_exists($controller)){
                $controllerObject = new $controller;
                $action = self::$route['action'];

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
        debug($name);
        return $name;
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