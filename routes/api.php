<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'API'], function () {
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
});
