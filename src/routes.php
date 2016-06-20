<?php


Route::add('/', 'HomeController', 'indexAction', 'get');
Route::add('home/:slug', 'HomeController', 'indexAction', 'get');
Route::get('home/:slug', 'HomeController', 'indexAction');
Route::post('home/:slug', 'HomeController', 'indexAction');