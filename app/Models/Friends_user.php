<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends_user extends Model
{
	use HasFactory;

	protected $guarded = [];

	protected $table = 'friend_user';

	public const friend_req = 0;

	public const friend = 1;

	public const ignored_user = 2;
}
