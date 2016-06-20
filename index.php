<?php

// Composer autoload...
require __DIR__ . '/vendor/autoload.php';


/**
 * Autoload yükleme!
 *
 * Yüklemelerde önce "core" dizinine bakılır. Kayıt bulunamazsa "src/Models" dizinine bakılır.
 * Dosya bulunursa require edilir.
 */
spl_autoload_register(function ($class) {
    if (file_exists('core/'. $class .'.php')) {
        require_once 'core/'. $class .'.php';
    } elseif (file_exists('src/Models/'. $class .'.php')) {
        require_once 'src/Models/'. $class .'.php';
    }
});




Config::load(require 'src/config.php');
Request::capture();

require 'src/routes.php';
Route::run();