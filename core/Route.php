<?php


/**
 * Class Route
 * @package Core
 */

class Route
{

    private static $routes = array();
    private static $action = array();


    public static function add($pattern, $controller, $action, $method = '*')
    {
        static::$routes[] = array(
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        );
    }

    public static function get($pattern, $controller, $action)
    {
        static::add($pattern, $controller, $action, 'GET');
    }

    public static function post($pattern, $controller, $action)
    {
        static::add($pattern, $controller, $action, 'POST');
    }

    public static function run()
    {
        $path = 'src/Controllers/';
        foreach (static::$routes as $route) {;

            if (static::method($route['method']) === true && static::match($route['pattern'], Request::path()) === true) {
                $file = $path . $route['controller'] .'.php';

                if (! file_exists($file)) {
                    throw new Exception('Controller does not exist!');
                }

                require $file;

                $instance = new $route['controller']();
                $instance->$route['action']();


                $path = "gittigin yol yol degil";
            }
        }
    }


    /**
     * Yönlendiricideki method ile Url methodunu karşılaştırır
     *
     * @param string $method
     * @return boolean
     */
    private static function method($method)
    {
        if ($method == '*'){
            return true;
        }
        $method = strtoupper($method);
        if (in_array($_SERVER['REQUEST_METHOD'], explode(',', $method))){
            return true;
        }

        return false;
    }


    /**
     * Route desenini eşleştirir
     *
     * @param string $pattern
     * @param string $value
     * @return boolean
     */
    private function match($pattern, $value)
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