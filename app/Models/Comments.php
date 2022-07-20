<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
	use HasFactory;

	protected $guarded=[];

	protected $table='comments';

	//####################################     relations     ##############################
	public function post()
	{
		return $this->belongsTo('App\Models\Posts', 'post_id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	//####################################     scopes       ##############################
	public function scopeSelection($q)
	{
		return $q->select('text', 'id', 'created_at', 'user_id', 'post_id');
	}
}
