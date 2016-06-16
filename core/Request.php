<?php

namespace Core;


class Request
{

    /**
     * Get değerini döndürür.
     *
     * @param null $key
     * @param null $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        return static::getArrayValue($_GET, $key, $default);
    }


    /**
     * Get değerini varlığını kontrol eder.
     *
     * @param null $key
     * @return bool
     */
    public static function hasGet($key)
    {
        $value = static::getArrayValue($_GET, $key, false);

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
        return static::getArrayValue($_POST, $key, $default);
    }


    /**
     * Post değerini varlığını kontrol eder.
     *
     * @param null $key
     * @return bool
     */
    public static function hasPost($key)
    {
        $value = static::getArrayValue($_POST, $key, false);

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
        return static::getArrayValue($_FILES, $key, $default);
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
        return static::getArrayValue($_COOKIE, $key, $default);
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
        return static::getArrayValue($_SERVER, $key, $default);
    }


    /**
     * İstemci ip adresini döndürür.
     *
     * @param string $default
     * @return mixed
     */
    public static function ip($default = '0.0.0.0')
    {
        return static::server('REMOTE_ADDR', $default);
    }


    /**
     * Protokolü döndürür.
     *
     * @return string
     */
    public static function protocol()
    {
        if (static::server('HTTPS') == 'on' || static::server('HTTPS') == 1 ||  static::server('SERVER_PORT') == 443) {
            return 'https';
        }

        return 'http';
    }


    /**
     * Ajax isteği kontrolü yapar.
     *
     * @return bool
     */
    public static function isAjax()
    {
        return (static::server('HTTP_X_REQUESTED_WITH') !== null) and strtolower(static::server('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest';
    }


    /**
     * İstek metodunu döndürür.
     *
     * @param string $default
     * @return mixed
     */
    public static function method($default = 'GET')
    {
        return static::server('REQUEST_METHOD', $default);
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
        return static::server('HTTP_HOST');
    }


    /**
     * İsten yolunu döndürür.
     *
     * @return mixed
     */
    public static function path()
    {
        $uri = explode('?', static::server('REQUEST_URI'));

        return ltrim($uri[0], '/');
    }

    /**
     * QueryString'i göndürür.
     *
     * @return mixed
     */
    public static function queryString()
    {
        return static::server('QUERY_STRING');
    }


    /**
     * Querystring harici Url'yi döndürür.
     *
     * @return string
     */
    public static function url()
    {
        return static::protocol() .'://'. static::host() .'/'. static::path();
    }

    /**
     * Querystring dahil tam Url'i döndürür.
     *
     * @return string
     */
    public static function fullUrl()
    {
        $queryString = static::queryString();

        return static::url() . (! empty($queryString) ? '?'.$queryString : '');
    }


    /**
     * Uri segmentleri döndürür.
     *
     * @return array
     */
    public static function segments()
    {
        return explode('/', static::path());
    }

    /**
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