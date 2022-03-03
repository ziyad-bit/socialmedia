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
    Route::any ('/index'       , 'SearchController@index')->name('search.index');
    Route::post('/show'        , 'SearchController@show');
    Route::get ('/show/recent' , 'SearchController@show_recent');
});

#######################################     friends     ######################################
Route::any ('friends/requests'  , 'Users\FriendsController@show_requests')->name('friends.show.requests');
Route::apiResource('friend'     , 'Users\FriendsController');

#######################################     chat     ######################################
Route::any ('message/index'         , 'Users\MessageController@index_friends')->name('message.index.friends');
Route::apiResource('message'        , 'Users\MessageController');

#######################################     posts     ######################################
Route::any ('posts/index'            , 'Users\PostsController@index_posts')->name('posts.index.all');
Route::post('post/{post}'            , 'Users\PostsController@update');
Route::apiResource('post'            , 'Users\PostsController');

#######################################     comments     ######################################
Route::get ('comments/show/{com_id}/{post_id}'  , 'Users\CommentsController@show_more');
Route::apiResource('comment'                    , 'Users\CommentsController');

#######################################     groups     ######################################
Route::any ('group/posts/{id}'  , 'Users\GroupsController@index_posts')->name('groups.posts.index');
Route::apiResource('group'      , 'Users\GroupsController');

#######################################     groups users    ######################################
//Route::any ('group/posts/{id}'  , 'Users\GroupsController@index_posts')->name('groups.posts.index');
Route::apiResource('group/users'  , 'Users\GroupUsersController');

#######################################     likes     ######################################
Route::post ('like/store'  , 'Users\LikesController@store');

#######################################     shares     ######################################
Route::post ('share/store'  , 'Users\SharesController@store');

#######################################     profile     ######################################
Route::group(['prefix'=>'profile','namespace'=>'Users'], function () {
    Route::any ('/index'       , 'ProfileController@index')->name('users.profile.index');
    Route::post('/update/photo', 'ProfileController@update_photo');
    Route::post('/update'      , 'ProfileController@update');
    Route::any ('/show'        , 'ProfileController@show')->name('users.profile.show');
});