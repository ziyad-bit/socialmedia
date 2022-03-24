<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//define('pagination',4);
/*
########################      admins login            ###############################
Route::group(['prefix'=>'admins','namespace'=>'Admins'], function () {
    Route::get ('/login'       , 'AdminsController@getLogin');
    Route::post('/login'       , 'AdminsController@login');
});

########################        auth admins           ###############################
Route::group(['prefix'=>LaravelLocalization::setLocale().'/admins','namespace'=>'admins'], function () {
    Route::get ('/dashboard'       , 'DashboardController@index')->name('admins.dashboard');
    Route::get ('/logout'          , 'AdminsController@logout')->name('admins.logout');
    Route::get ('/index'           , 'AdminsController@index')->name('admins.index');
    Route::get ('/create'          , 'AdminsController@create')->name('admins.create');
    Route::post('/store'           , 'AdminsController@store')->name('admins.store');
    Route::get ('/edit/{id}'       , 'AdminsController@edit')->name('admins.edit');
    Route::post('/update/{id}'     , 'AdminsController@update')->name('admins.update');
    Route::get ('/delete/{id}'     , 'AdminsController@delete')->name('admins.delete');
});

########################        languages           ###############################
Route::resource(LaravelLocalization::setLocale().'/admins/languages', Admins\LanguagesController::class);

########################        groups           ###############################
Route::group(['prefix'=>LaravelLocalization::setLocale().'admins/groups','namespace'=>'admins'], function () {
    Route::put ('/change/{id}'     , 'GroupsController@change')->name('groups.change');
    Route::post('/add/{id}'        , 'GroupsController@add_lang')->name('groups.add_lang');
});

Route::resource(LaravelLocalization::setLocale().'/admins/groups', Admins\GroupsController::class);
*/