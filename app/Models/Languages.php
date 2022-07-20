<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
	use HasFactory;

	protected $guarded=[];

	protected $table='languages';

	public $timestamps=false;
}
