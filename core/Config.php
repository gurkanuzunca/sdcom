<?php


class Config
{

    private static $items;

    public static function load(array $array)
    {
        static::$items = $array;
    }

    /**
     * Key'i verilen ayarı döndürür.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        return static::getArrayValue(static::$items, $key, $default);
    }


    /**
     * Key'e değer atar.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public static function set($key = null, $value)
    {
        return static::setArrayValue(static::$items, $key, $value);
    }

    /**
     * Tüm ayarları döndürür.
     *
     * @return mixed
     */
    public static function all()
    {
        return static::get();
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


    /**
     * Dizi içerisine değer atar.
     * Dot Notation deniliyor "key.key.key" olayına.
     *
     * @param array $array
     * @param string $key Diziye eklenmek istenen key veya path (key.key.key).
     * @param mixed $value Keye eklenmek istenen değer.
     * @return array
     */
    private static function setArrayValue(array &$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        foreach (explode('.', $key) as $part) {
            if (! isset($array[$part])) {
                $array[$part] = array();
            }

            $array =& $array[$part];
        }

        $array = $value;

        return $array;
    }
}