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

Route::group(['prefix'=>'users_search','namespace'=>'Users'], function () {
    Route::any ('/index'       , 'SearchController@index')->name('users_search.index');
    Route::post('/show'        , 'SearchController@show');
    Route::get ('/show/recent' , 'SearchController@show_recent');
});

#######################################     users     ######################################
Route::resource('users',Users\UsersController::class);

#######################################     friends     ######################################
Route::any ('friends/requests'  , 'Users\FriendsController@show_requests')->name('users_friends.show_requests');
Route::apiResource('users_friends',Users\FriendsController::class);

#######################################     chat     ######################################
Route::any ('chat/index_friends'  , 'Users\ChatController@index_friends')->name('users_chat.index_friends');
Route::apiResource('users_chat',Users\ChatController::class);

#######################################     posts     ######################################
Route::apiResource('users_posts',Users\PostsController::class);

#######################################     comments     ######################################
Route::get ('users_comments/show_more/{com_id}/{post_id}'  , 'Users\CommentsController@show_more');
Route::apiResource('users_comments',Users\CommentsController::class);