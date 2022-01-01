<?php

use Illuminate\Support\Facades\Route;

define('pagination',4);

########################      admins login            ###############################
Route::group(['prefix'=>'admins','namespace'=>'Admins','middleware'=>'guest:admins'], function () {
    Route::get ('/login'       , 'AdminsController@getLogin');
    Route::post('/login'       , 'AdminsController@login');
});

########################        auth admins           ###############################
Route::group(['prefix'=>'admins','namespace'=>'admins','middleware'=>'auth:admins'], function () {
    Route::get ('/dashboard'       , 'DashboardController@index');
    Route::get ('/logout'          , 'AdminsController@logout');
    Route::get ('/index'           , 'AdminsController@index');
    Route::get ('/create'          , 'AdminsController@create');
    Route::post('/store'           , 'AdminsController@store');
    Route::get ('/edit/{id}'       , 'AdminsController@edit');
    Route::post('/update/{id}'     , 'AdminsController@update');
    Route::get ('/delete/{id}'     , 'AdminsController@delete');
});

########################        languages           ###############################
Route::resource('admins/languages', Admins\LanguagesController::class);