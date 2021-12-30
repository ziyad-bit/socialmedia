<?php

use Illuminate\Support\Facades\Route;

########################      admins login            ###############################
Route::group(['prefix'=>'admins','namespace'=>'Admins','middleware'=>'guest:admins'], function () {
    Route::get ('/login'       , 'AdminsController@getLogin');
    Route::post('/login'       , 'AdminsController@login');
});

########################        dashboard           ###############################
Route::group(['prefix'=>'admins','namespace'=>'admins','middleware'=>'auth:admins'], function () {
    Route::get ('/dashboard'       , 'DashboardController@index');
});