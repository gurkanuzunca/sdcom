<?php

class Assets
{
    private static $assets = [];

    /**
     * Magic method.
     * Kullanılan method ismine göre asset kaydı yapar.
     * Kullanım: Assets::js('path/to/file.js');
     *           Assets::js(array('path/to/file.js', 'path/to/file.js'));
     *           $assets = Assets::js();
     *           $assets = Assets::css();
     *
     * @param $name
     * @param $arguments
     * @return bool
     */
    public function __callStatic($name, $arguments)
    {
        return static::set($name, $arguments);
    }


    /**
     * Javascript ve css dosyalarını sisteme tanımlar veya dosyaları göndürür.
     *
     * @param $type
     * @param array $sources
     * @return bool
     */
    public static function set($type, $sources = [])
    {
        if (empty($sources)) {
            if (isset(static::$assets[$type])) {
                return static::$assets[$type];
            }

            return array();
        }

        if (! is_array($sources)) {
            $sources = array($sources);
        }

        if (! isset(static::$assets[$type])) {
            static::$assets[$type] = [];
        }

        static::$assets[$type] = array_merge(static::$assets[$type], $sources);

    }


}