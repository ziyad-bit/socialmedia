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

#######################################     Message     ######################################
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
Route::any ('group/posts/{group}'  , 'Users\GroupsController@index_posts')->name('groups.posts.index');
Route::any ('group/index-groups'   , 'Users\GroupsController@index_groups')->name('groups.index_groups');
Route::post('group/update/{group}' , 'Users\GroupsController@update');
Route::Resource('group'            , 'Users\GroupsController');

#######################################     groups users    ######################################
Route::put ('group-users/punish/{group_user}'  , 'Users\GroupUsersController@punish');
Route::apiResource('group-users'               , 'Users\GroupUsersController')->parameter('group-users','group_user');

#######################################     groups admins    ######################################R
Route::apiResource('group-admins'               , 'Users\GroupAdminsController')->parameter('group-admins','group_admin');

#######################################     groups reqs    ######################################
Route::put ('group/reqs/ignore/{group_req}'    , 'Users\GroupReqsController@ignore');
Route::apiResource('group/reqs'                , 'Users\GroupReqsController')->parameter('reqs','group_req');

#######################################     likes     ######################################
Route::post ('like/store'  , 'Users\LikesController@store');

#######################################     shares     ######################################
Route::post ('share/store'  , 'Users\SharesController@store');

#######################################     profile     ######################################
Route::group(['prefix'=>'profile','namespace'=>'Users'], function () {
    Route::any ('/index/auth'           , 'ProfileController@index')->name('users.profile.index');
    Route::post('/update/photo'         , 'ProfileController@update_photo');
    Route::post('/update'               , 'ProfileController@update');
    Route::any ('/show'                 , 'ProfileController@show')->name('users.profile.show');
    Route::any ('/index/other/{name}'   , 'ProfileController@index_profile')->name('users.index');
    Route::any ('/index/friends/{name}' , 'ProfileController@show_friends')->name('users.friends.index');
});