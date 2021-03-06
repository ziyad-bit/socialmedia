<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable implements MustVerifyEmail
{
	use HasApiTokens, HasFactory, Notifiable,SearchableTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $guarded = [];

	protected $searchable = [
		'columns' => [
			'users.name' => 10,
		],
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	//############################    relations   ########################################
	public function auth_add_friends()
	{
		return $this->belongsToMany(self::class, 'App\Models\Friends_user', 'friend_id', 'user_id')
			->as('request')->withPivot('status', 'id');
	}

	public function friends_add_auth()
	{
		return $this->belongsToMany(self::class, 'App\Models\Friends_user', 'user_id', 'friend_id')
			->as('request')->withPivot('status', 'id');
	}

	public function group_joined()
	{
		return $this->belongsToMany("App\Models\Groups", 'App\Models\Group_users', 'user_id', 'group_id')
		->as('request')->withPivot('status', 'id', 'punish');
	}

	public function searches()
	{
		return $this->hasMany("App\Models\Searches", 'user_id');
	}

	public function messages()
	{
		return $this->hasMany('App\Models\Messages', 'sender_id');
	}

	public function posts()
	{
		return $this->hasMany('App\Models\Posts', 'user_id');
	}

	public function comments()
	{
		return $this->hasMany('App\Models\Comments', 'user_id');
	}

	public function shares()
	{
		return $this->hasMany('App\Models\Shares', 'user_id');
	}

	//############################       scopes        ########################################
	public function scopeSelection($q)
	{
		return $q->select('name', 'work', 'photo', 'id', 'online');
	}

	public function scopeNotAuth($q)
	{
		return $q->where('id', '!=', Auth::id());
	}

	public function scopeFriends_add_auth($q)
	{
		return $q->where(['status' => 1, 'friend_id' => Auth::id()]);
	}

	public function scopeAuth_add_friends($q)
	{
		return $q->where(['status' => 1, 'user_id' => Auth::id()]);
	}

	public function scopeAuthUser($q)
	{
		return $q->where('user_id', Auth::id());
	}

	public function scopeAuthFriend($q)
	{
		return $q->where('friend_id', Auth::id());
	}
}
