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


#######################################     users     ######################################
Route::resource('users',Users\UsersController::class);

#######################################     friends     ######################################
Route::any ('friends/requests'  , 'Users\FriendsController@show_requests')->name('users.friends.show_requests');
Route::apiResource('friends',Users\FriendsController::class);

#######################################     chat     ######################################
Route::any ('chat/index_friends'  , 'Users\ChatController@index_friends')->name('users.chat.index_friends');
Route::apiResource('chat',Users\ChatController::class);

#######################################     posts     ######################################
Route::any ('/show_posts'  , 'Users\PostsController@show_posts')->name('users.posts.index_posts');
Route::apiResource('posts',Users\ChatController::class);

#######################################     comments     ######################################
Route::apiResource('comments',Users\CommentsController::class);