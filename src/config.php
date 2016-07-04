<?php


return [
    // Hata kodlarını açıp kapatır
    'displayError' => true,

    // Varsayılan zaman dilimi
    'timezone' => 'Europe/Istanbul',

    // Veritabanı ayarları
    'database' => array(
        'host'      => 'localhost',
        'database'  => 'symfony',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8'
    ),

    'assets' => array(
        'cssCache' => 'public/assets/cache.css',
        'jsCache' => 'public/assets/cache.js'
    )

];