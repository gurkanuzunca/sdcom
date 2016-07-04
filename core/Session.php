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

    /**
     * @param $key
     * @return mixed
     */
    public static function has($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        }

        return false;
    }


    public function flash($key)
    {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);

            return $value;
        }

        return false;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
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


