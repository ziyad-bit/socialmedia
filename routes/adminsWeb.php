<?php

use Illuminate\Support\Facades\Route;

//#######################      admins login            ###############################
Route::group(['namespace'=>'Admins'], function () {
	Route::get('/login', 'AdminsAuthController@getLogin')->name('admins.get.login');
	Route::post('/login', 'AdminsAuthController@login')->name('admins.post.login');
	Route::get('/resetpassword/link', 'AdminsAuthController@getresetPasswordLink')->name('admins.get.resetPasswordLink');
	Route::post('/resetpassword/link', 'AdminsAuthController@sendResetPasswordLink')->name('admins.send.resetPasswordLink');
	Route::get('/reset/password/{token}/{email}', 'AdminsAuthController@editPassword');
	Route::post('/update/password', 'AdminsAuthController@updatePassword')->name('admins.update.password');
	Route::get('/logout', 'AdminsAuthController@logout')->name('admins.logout');
});

//#######################         admins           ###############################
Route::group(['namespace'=>'admins'], function () {
	Route::get('/dashboard', 'DashboardController@index')->name('admins.dashboard');
	Route::get('/index', 'AdminsController@index')->name('admins.index');
	Route::get('/create', 'AdminsController@create')->name('admins.create');
	Route::post('/store', 'AdminsController@store')->name('admins.store');
	Route::get('/edit/{id}', 'AdminsController@edit')->name('admins.edit');
	Route::post('/update/{id}', 'AdminsController@update')->name('admins.update');
	Route::get('/delete/{id}', 'AdminsController@delete')->name('admins.delete');
});

//#######################        languages           ###############################
Route::resource('/admins-language', Admins\LanguagesController::class)->parameter('admins-language', 'admins_language')->except('show');


//#######################        groups           ###############################
Route::resource('/admins-groups', Admins\GroupsController::class)->parameter('admins-groups', 'admins_group')->except('show');

//#######################        comments           ###############################
Route::resource('/admins-comments', Admins\CommentsController::class)->parameter('admins-comments', 'admins_comment')->except(['show', 'store', 'create']);

//#######################        users           ###############################
Route::put('/update/password/{admins_user}', 'Admins\UsersController@updatePassword')->name('admins.update.user.password');
Route::get('/edit/password/{admins_user}', 'Admins\UsersController@editPassword')->name('admins.edit.user.password');
Route::resource('/admins-users', Admins\UsersController::class)->parameter('admins-users', 'admins_user')->except('show');
