<?php
Route::group(['prefix' => 'admin'], function () {

    // Products routes
    Route::get('/products', 'ProductController@index');
    Route::get('/product/{product}/show', 'ProductController@show');
    Route::put('/product/{product}/update', 'ProductController@update');
    Route::post('/product/store', 'ProductController@store');
    Route::delete('/product/{product}/destroy', 'ProductController@destroy');

    // User routes
    Route::get('/users', 'UserController@index');
    Route::get('/user/{user}/show', 'UserController@show');
    Route::put('/user/{user}/update', 'UserController@update');
    Route::post('/user/store', 'UserController@store');
    Route::delete('/user/{user}/destroy', 'UserController@destroy');

});
