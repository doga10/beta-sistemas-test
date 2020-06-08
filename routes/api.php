<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'API'], function () {
    Route::post('login', 'AuthController@login');
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
    Route::resource('contacts', 'ContactController', ['except' => ['create', 'edit']]);
});
