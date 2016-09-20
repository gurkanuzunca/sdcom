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
        return Helper::getArrayValue(static::$items, $key, $default);
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
        return Helper::setArrayValue(static::$items, $key, $value);
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



}