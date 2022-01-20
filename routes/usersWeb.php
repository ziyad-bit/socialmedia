<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'search','namespace'=>'Users'], function () {
    Route::any ('/index'       , 'SearchController@index')->name('users.search.index');
    Route::post('/show'        , 'SearchController@show');
    Route::get ('/show/recent' , 'SearchController@show_recent');
});

Route::resource('users',Users\UsersController::class);

Route::apiResource('friends',Users\FriendsController::class);