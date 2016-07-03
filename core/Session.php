<?php


class Session
{

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return false;
    }


    public function flash($var)
    {
        if (isset($_SESSION[$var])) {
            $value = $_SESSION[$var];
            unset($_SESSION[$var]);

            return $value;
        }

        return false;
    }

    /**
     * @param $var
     * @param $value
     * @return bool
     */
    public static function set($var, $value)
    {
        $_SESSION[$var] = $value;
    }

    /**
     * @return string
     */
    public static function id()
    {
        return session_id();
    }


    /**
     * @param null $key
     * @return bool
     */
    public static function destroy($key = null)
    {
        if (! is_null($key)) {
            if (isset($_SESSION[$key])) {
                $_SESSION[$key] = NULL;
                unset($_SESSION[$key]);
            } else {
                return false;
            }
            return true;
        }

        session_destroy();
    }

}


