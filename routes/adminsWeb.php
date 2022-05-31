<?php

use Illuminate\Support\Facades\Route;

define('pagination',4);

########################      admins login            ###############################
Route::group(['namespace'=>'Admins'], function () {
    Route::get ('/login'                    , 'AdminsAuthController@getLogin')->name('admins.get.login');
    Route::post('/login'                    , 'AdminsAuthController@login')->name('admins.post.login');
    Route::get ('/reset/password'           , 'AdminsAuthController@getPassword')->name('admins.get.password');
    Route::post('/reset/password'           , 'AdminsAuthController@resetPassword')->name('admins.reset.password');
    Route::get ('/reset/password/{token}'   , 'AdminsAuthController@getResetForm');
});

########################        auth admins           ###############################
Route::group(['namespace'=>'admins'], function () {
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
Route::resource('/languages', Admins\LanguagesController::class);

########################        groups           ###############################
Route::group(['groups','namespace'=>'admins'], function () {
    Route::put ('/change/{id}'     , 'GroupsController@change')->name('groups.change');
    Route::post('/add/{id}'        , 'GroupsController@add_lang')->name('groups.add_lang');
});

Route::resource('/groups', Admins\GroupsController::class);
