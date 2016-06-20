<?php


require __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    if (file_exists('core/'. $class .'.php')) {
        require_once 'core/'. $class .'.php';
    } elseif (file_exists('src/Models/'. $class .'.php')) {
        require_once 'src/Models/'. $class .'.php';
    }
});

/*
 * Hello papa
 */
require 'src/routes.php';

Request::capture();

Route::run();