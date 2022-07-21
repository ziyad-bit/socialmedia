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
//######################################     privacy policy and data deletion urls    ######################################
Route::group(['namespace' => 'Users'], function () {
	Route::get('/data/deletion' , 'GeneralController@getDataDeletion');
	Route::get('/privacy/policy', 'GeneralController@getPrivacyPolicy');
});

//######################################     auth routes     ######################################
Auth::routes(['verify' => true]);
Route::get('/email/verify', 'Auth\VerificationController@verifyEmail')->middleware('auth')->name('verification.notice');

//######################################     facebook login     ######################################
Route::group(['prefix' => 'auth/facebook', 'namespace' => 'Users'], function () {
	Route::get('/redirect', 'FaceBookController@redirect')->name('facebook.redirect');
	Route::get('/callback', 'FaceBookController@callback');
});

//######################################     search     ######################################
Route::group(['prefix' => 'search', 'namespace' => 'Users'], function () {
	Route::any('/index'      , 'SearchController@index')->name('search.index');
	Route::post('/show'      , 'SearchController@show');
	Route::get('/show/recent', 'SearchController@show_recent');
});

//######################################     notifications     ######################################
Route::group(['prefix' => 'notifications', 'namespace' => 'Users'], function () {
	Route::put('/update'              , 'NotificationsController@update');
	Route::get('/show/{last_notif_id}', 'NotificationsController@show_more');
});

//######################################     friends     ######################################
Route::group(['prefix' => 'friends', 'namespace' => 'Users'], function () {
	Route::any('requests'                , 'FriendsController@show_requests')->name('friends.show.requests');
	Route::put('requests/ignore/{friend}', 'FriendsController@ignore');
});

Route::apiResource('friend', 'Users\FriendsController')->only(['store', 'update', 'destroy']);

//######################################     Message     ######################################
Route::group(['prefix' => 'message', 'namespace' => 'Users'], function () {
	Route::any('index', 'MessageController@index_friends')->name('message.index.friends');
	Route::post('search-friends'  , 'MessageController@search_friends');
	Route::post('search-last-msgs', 'MessageController@search_last_msgs');
});

Route::apiResource('message', 'Users\MessageController')->only(['store', 'update', 'show']);

//######################################     posts     ######################################
Route::any('/'           , 'Users\PostsController@index_posts')->name('posts.index.all');
Route::post('post/{post}', 'Users\PostsController@update');

Route::apiResource('post', 'Users\PostsController')->only(['store', 'update', 'destroy']);

//######################################     comments     ######################################
Route::get('comment/show/{com_id}/{post_id}', 'Users\CommentsController@show_more');
Route::apiResource('comment'                , 'Users\CommentsController')->only(['store', 'update', 'destroy']);

//######################################     groups     ######################################
Route::group(['prefix' => 'group', 'namespace' => 'Users'], function () {
	Route::any('posts/{slug}'   , 'GroupsController@index_posts')->name('groups.posts.index');
	Route::any('index-groups'   , 'GroupsController@index_groups')->name('groups.index_groups');
	Route::post('update/{group}', 'GroupsController@update');
});

Route::Resource('/group', 'Users\GroupsController')->only(['store', 'update', 'destroy', 'create']);

//######################################     groups users    ######################################
Route::put('/group-users/punish/{group_user}', 'Users\GroupUsersController@punish');
Route::apiResource('/group-users'            , 'Users\GroupUsersController')->parameter('group-users', 'group_user')->only(['show', 'update', 'destroy']);

//######################################     groups admins    ######################################R
Route::apiResource('/group-admins', 'Users\GroupAdminsController')->parameter('group-admins', 'group_admin')->only(['show', 'update', 'destroy']);
//######################################     groups reqs    ######################################
Route::put('/group/requests/ignore/{group_request}', 'Users\GroupReqsController@ignore');
Route::apiResource('/group-requests'               , 'Users\GroupReqsController')->only(['store', 'update', 'destroy', 'show']);
//######################################     likes     ######################################
Route::post('/like/store', 'Users\LikesController@store');

//######################################     shares     ######################################
Route::post('/share/store', 'Users\SharesController@store');

//######################################     profile     ######################################
Route::group(['prefix' => 'profile', 'namespace' => 'Users'], function () {
	Route::any('/index/auth'          , 'ProfileController@index')->name('users.profile.index');
	Route::post('/update/photo'       , 'ProfileController@update_photo');
	Route::post('/update'             , 'ProfileController@update');
	Route::any('/show'                , 'ProfileController@show')->name('users.profile.show');
	Route::any('/index/other/{name}'  , 'ProfileController@index_profile')->name('users.index');
	Route::any('/index/friends/{name}', 'ProfileController@show_friends')->name('users.friends.index');
});
