<?php


class Response
{
    private static $headers = array(
       'Content-Type' => 'text/html; charset=utf-8'
    );

    private static $body;

    /**
     * View dosyası render edererek response body oluşturur.
     *
     * @param $file
     * @param array $data
     * @throws Exception
     */
    public static function render($file, array $data = array())
    {
        $file = 'src/Views/'. $file .'.php';

        if (! file_exists($file)) {
            throw new Exception('View dosyasi bulunamadi.');
        }

        extract($data);
        ob_start();
        include $file;

        static::$body = ob_get_clean();
    }

    /**
     * Response body olarak json oluşturur.
     *
     * @param $data
     */
    public static function json($data)
    {
        static::setHeader('Content-Type', 'application/json;charset=utf-8');
        static::$body = json_encode($data);
    }

    /**
     * Yönlendirme yapar.
     *
     * @param $url
     */
    public static function redirect($url)
    {
        static::setHeader('Location', $url);
    }

    /**
     * Response body döndürür.
     */
    public static function getBody()
    {
        static::$body;
    }

    /**
     * Http header tanımlar.
     *
     * @param $key
     * @param $value
     * @param bool|true $replace
     */
    public static function setHeader($key, $value, $replace = true)
    {
        if ($replace === true) {
            static::$headers[$key] = $value;
        } else {
            if (! isset(static::$headers[$key])) {
                static::$headers[$key] = $value;
            }
        }
    }

    /**
     * Http headerları döndürür.
     *
     * @param null $key
     * @return array
     */
    public static function getHeader($key = null)
    {
        if ($key === null) {
            return static::$headers;
        } else {
            if (! isset(static::$headers[$key])) {
                return static::$headers[$key];
            }
        }

        return array();
    }

    /**
     * Response çıktısını ekrana basar.
     */
    public static function write()
    {
        static::sendHeaders();

        echo static::$body;
    }

    /**
     * Http header bilgilerini işler.
     */
    private static function sendHeaders()
    {
        header_remove("X-Powered-By");

        foreach (static::getHeader() as $key => $value) {
            header(sprintf('%s: %s', $key, $value), false);
        }
    }

}