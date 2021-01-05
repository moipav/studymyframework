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
            echo 'OK';
        }else{
            http_response_code(404);
            include '404.html';
        }
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