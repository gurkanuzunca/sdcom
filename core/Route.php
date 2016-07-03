<?php


/**
 * Class Route
 * @package Core
 */

class Route
{
    private static $path = 'src/Controllers/';
    private static $routes = array();
    private static $action;


    /**
     * Rotasyon eklemesi yapılır.
     *
     * @param $pattern
     * @param $controller
     * @param $action
     * @param string $method
     */
    public static function add($pattern, $controller, $action, $method = '*')
    {
        static::$routes[] = array(
            'pattern' => trim($pattern, '/'),
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        );
    }


    /**
     * Metod GET olarak rotasyon eklemesi yapılır.
     *
     * @param $pattern
     * @param $controller
     * @param $action
     */
    public static function get($pattern, $controller, $action)
    {
        static::add($pattern, $controller, $action, 'GET');
    }


    /**
     * Metod POST olarak rotasyon eklemesi yapılır.
     * @param $pattern
     * @param $controller
     * @param $action
     */
    public static function post($pattern, $controller, $action)
    {
        static::add($pattern, $controller, $action, 'POST');
    }


    /**
     * Rotasyonlar sırayla kontrol edilir. Eşleşen rotasyon çalıştırılır.
     *
     * @return bool
     * @throws Exception
     */
    public static function run()
    {
        foreach (static::$routes as $route) {;

            if (static::method($route['method']) === true && static::match($route['pattern'], Request::path()) === true) {
                $file = static::$path . $route['controller'] .'.php';

                if (! file_exists($file)) {
                    throw new Exception('Controller does not exist!');
                }

                require $file;

                $instance = new $route['controller']();
                $instance->$route['action']();

                static::$action = $route;

                return true;

            }
        }
    }


    /**
     * Çalıştırılan rotasyon bilgisini döndürür.
     *
     * @return bool|array
     */
    public static function getAction()
    {
        if (static::$action === null) {
            return false;
        }

        return static::$action;
    }


    /**
     * Yönlendiricideki method ile Url methodunu karşılaştırır
     *
     * @param string $method
     * @return bool
     */
    private static function method($method)
    {
        if ($method == '*'){
            return true;
        }

        if (in_array($_SERVER['REQUEST_METHOD'], explode(',', strtoupper($method)))){
            return true;
        }

        return false;
    }


    /**
     * Route desenini eşleştirir
     *
     * @param string $pattern
     * @param string $value
     * @return bool
     */
    private static function match($pattern, $value)
    {
        return preg_match('@^'.$pattern.'$@i', $value) ? true : false;
    }


    /**
     * Route parametrelerini desene çevirir
     *
     * @param string $url
     * @return string
     */
    private function pattern($url)
    {
        return str_replace(':any', '.+', str_replace(':num', '[0-9]+', $url));
    }

}