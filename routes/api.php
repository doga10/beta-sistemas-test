<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'API'], function () {
    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::get('redirect', 'AuthController@facebookRedirect')->name('auth.facebook.redirect');
    Route::get('callback', 'AuthController@facebookCallback')->name('auth.facebook.callback');
    Route::post('users', 'UserController@store')->name('users.store');
    Route::get('users/contacts', 'ContactController@contacts')->middleware('auth:api')->name('users.contacts');
    Route::get('users', 'UserController@all')->middleware('auth:api')->name('users.index');
    Route::put('users/{user}', 'UserController@update')->middleware('auth:api')->name('users.update');
    Route::get('users/{user}', 'UserController@show')->middleware('auth:api')->name('users.show');
    Route::delete('users/{user}', 'UserController@destroy')->middleware('auth:api')->name('users.destroy');
    Route::middleware('auth:api')->group(function () {
        Route::resource('contacts', 'ContactController', ['except' => ['create', 'edit']]);
    });
});
