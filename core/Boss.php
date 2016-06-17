<?php


/**
 * Class Request
 * @package Core
 */

class Boss
{

    public function __construct()
    {
        Request::capture();
        include 'src/Controllers/HomeController.php';
    }

    public function model()
    {
        echo 'ok';
    }

}