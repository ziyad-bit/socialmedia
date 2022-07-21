<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
	use HasFactory;

	protected $guarded = [];

	protected $table = 'likes';

	public $timestamps = false;

	public function posts()
	{
		return $this->belongsTo('App\Models\Posts', 'post_id');
	}
}
