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
    public static function __callStatic($name, $arguments)
    {
        if (empty($arguments)) {
            return static::get($name);
        }

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
        if (! is_array($sources)) {
            $sources = array($sources);
        }

        if (! isset(static::$assets[$type])) {
            static::$assets[$type] = [];
        }

        static::$assets[$type] = array_merge(static::$assets[$type], $sources);

    }



    public static function get($type)
    {
        if (isset(static::$assets[$type])) {
            return static::$assets[$type];
        }

        return array();
    }



    public static function concat($type, $version = null)
    {
        $config = Config::get('assets');
        $output = '';
        $mergeFiles = array();
        $files = array();

        foreach (static::get('css') as $file) {
            if (file_exists($file)) {
                $mergeFiles[] = $file;
            } else {
                $files[] = $file;
            }
        }

        if (! file_exists($config['cssCache'])) {
            foreach ($mergeFiles as $file) {
                $content = file_get_contents($file);
                $dir = dirname($file);

                $path = Request::baseUrl() . $dir .'/' ;
                $search = '#url\((?!\s*[\'"]?(?:https?:)?//)\s*([\'"])?#';
                $replace = "url($1{$path}";
                $output .= preg_replace($search, $replace, $content);
            }

            $handler = fopen($config['cssCache'], 'a');
            fwrite($handler, $output);
            fclose($handler);
        }

        $files[] = $config['cssCache'];


        return $files;
    }


}