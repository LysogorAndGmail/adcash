<?php

Route::get('/', 'HomeController@index');
Route::get('/login-register', 'PublicPageController@loginRegister');
Route::get('/lang/{lang}', 'LanguageController@changeLang');
Route::get('/session-lang', 'LanguageController@sessionLang');

Auth::routes();


// Orders routes
Route::get('/orders/{type}', 'OrderController@index');
Route::get('/orders/{type}/{search}', 'OrderController@search');
Route::get('/order/{order}/show', 'OrderController@show');
Route::put('/order/{order}/update', 'OrderController@update');
Route::post('/order/store', 'OrderController@store');
Route::delete('/order/{order}/destroy', 'OrderController@destroy');
