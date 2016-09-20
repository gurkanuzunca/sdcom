<?php

/**
 * Class Helper
 * Genel helper sınıfı..
 */
class Helper
{

    /**
     * Dizi içerisindeki değeri döndürür.
     * Dot Notation deniliyor "key.key.key" olayına.
     *
     * @param array $array
     * @param string $key Diziden çekilmek istenen key veya path (key.key.key).
     * @param null $default Bulunamaması durumunda varsayılan değer.
     * @return mixed
     */
    public static function getArrayValue(array $array, $key, $default = null)
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
    public static function setArrayValue(array &$array, $key, $value)
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