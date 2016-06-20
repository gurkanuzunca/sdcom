<?php


/**
 * Class Request
 * @package Core
 */

class Request
{

    private static $gets;
    private static $posts;
    private static $files;
    private static $cookies;
    private static $server;

    private static $ip;
    private static $protocol;
    private static $isAjax;
    private static $method;
    private static $host;
    private static $path;
    private static $queryString;
    private static $url;
    private static $fullUrl;
    private static $segments;


    public static function capture()
    {
        static::$gets = $_GET;
        static::$posts = $_POST;
        static::$files = $_FILES;
        static::$cookies = $_COOKIE;
        static::$server = $_SERVER;
    }

    /**
     * Get değerini döndürür.
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        return static::getArrayValue(static::$gets, $key, $default);
    }


    /**
     * Get değerini varlığını kontrol eder.
     *
     * @param null $key
     * @return bool
     */
    public static function hasGet($key)
    {
        $value = static::getArrayValue(static::$gets, $key, false);

        if ($value !== false || $value !== '') {
            return true;
        }

        return false;
    }


    /**
     * Post değerini döndürür.
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public static function post($key = null, $default = null)
    {
        return static::getArrayValue(static::$posts, $key, $default);
    }


    /**
     * Post değerini varlığını kontrol eder.
     *
     * @param null $key
     * @return bool
     */
    public static function hasPost($key)
    {
        $value = static::getArrayValue(static::$posts, $key, false);

        if ($value !== false || $value !== '') {
            return true;
        }

        return false;
    }


    /**
     * Dosya değerini döndürür.
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public static function file($key = null, $default = null)
    {
        return static::getArrayValue(static::$files, $key, $default);
    }


    /**
     * Çerez değerinin döndürür.
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public static function cookie($key = null, $default = null)
    {
        return static::getArrayValue(static::$cookies, $key, $default);
    }


    /**
     * Sunucu bilgisini döndürür.
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public static function server($key = null, $default = null)
    {
        return static::getArrayValue(static::$server, $key, $default);
    }


    /**
     * İstemci ip adresini döndürür.
     *
     * @return mixed
     */
    public static function ip()
    {
        if (static::$ip === null) {
            static::$ip = static::server('REMOTE_ADDR');
        }

        return static::$ip;
    }


    /**
     * Protokolü döndürür.
     *
     * @return string
     */
    public static function protocol()
    {
        if (static::$protocol === null) {
            if (static::server('HTTPS') == 'on' || static::server('HTTPS') == 1 ||  static::server('SERVER_PORT') == 443) {
                static::$protocol = 'https';
            }

            static::$protocol = 'http';
        }

        return static::$protocol;
    }


    /**
     * Ajax isteği kontrolü yapar.
     *
     * @return bool
     */
    public static function isAjax()
    {
        if (static::$isAjax === null) {
            static::$isAjax = (static::server('HTTP_X_REQUESTED_WITH') !== null) and strtolower(static::server('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest';
        }

        return static::$isAjax;
    }


    /**
     * İstek metodunu döndürür.
     *
     * @return mixed
     */
    public static function method()
    {
        if (static::$method === null) {
            static::$method = static::server('REQUEST_METHOD');
        }

        return static::$method;
    }


    /**
     * Metod kontrolu yapar.
     *
     * @param string $method
     * @return bool
     */
    public static function isMethod($method)
    {
        if (strtoupper($method) === static::method()) {
            return true;
        }

        return false;
    }

    /**
     * Sunucu Adını döndürür.
     *
     * @return mixed
     */
    public static function host()
    {
        if (static::$host === null) {
            static::$host = static::server('HTTP_HOST');
        }

        return static::$host;
    }


    /**
     * İsten yolunu döndürür.
     *
     * @return mixed
     */
    public static function path()
    {
        if (static::$path === null) {
            $request = static::server('REQUEST_URI');
            $dir = dirname(static::server('SCRIPT_NAME'));
            $request = str_replace($dir, '', $request);
            $uri = explode('?', $request);
            static::$path = ltrim($uri[0], '/') .'/';
        }

        return static::$path;
    }

    /**
     * QueryString'i göndürür.
     *
     * @return mixed
     */
    public static function queryString()
    {
        if (static::$queryString === null) {
            static::$queryString = static::server('QUERY_STRING');
        }

        return static::$queryString;
    }


    /**
     * Querystring harici Url'yi döndürür.
     *
     * @return string
     */
    public static function url()
    {
        if (static::$url === null) {
            static::$url = static::protocol() .'://'. static::host() .'/'. static::path();
        }

        return static::$url;
    }

    /**
     * Querystring dahil tam Url'i döndürür.
     *
     * @return string
     */
    public static function fullUrl()
    {
        if (static::$fullUrl === null) {
            $queryString = static::queryString();
            static::$fullUrl = static::url() . (! empty($queryString) ? '?'.$queryString : '');
        }

        return static::$fullUrl;
    }


    /**
     * @todo çalışma dizini dışındaki veriler getirilecek.
     * Uri segmentleri döndürür.
     *
     * @return array
     */
    public static function segments()
    {
        if (static::$segments === null) {
            static::$segments = explode('/', static::path());
        }

        return static::$segments;
    }

    /**
     * @todo çalışma dizini dışındaki veriler getirilecek.
     * İndisi verilen gegment değerini döndürür.
     *
     * @param int $index
     * @param string|null $default
     * @return mixed
     */
    public static function segment($index, $default = null)
    {
        $segments = static::segments();

        if (isset($segments[$index])) {
            return $segments[$index];
        } else {
            return $default;
        }
    }



    /**
     * Dizi içerisindeki değeri döndürür.
     * Dot Notation deniliyor "key.key.key" olayına.
     *
     * @param array $array
     * @param string $key Diziden çekilmek istenen key veya path (key.key.key).
     * @param null $default Bulunamaması durumunda varsayılan değer.
     * @return mixed
     */
    private static function getArrayValue(array $array, $key, $default = null)
    {

        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $part) {
            if (isset($array[$part])) {
                $array = $array[$part];
            } else {
                return $default;
            }
        }

        return $array;
    }
}

