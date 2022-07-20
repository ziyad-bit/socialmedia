<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
	use HasFactory;

	protected $guarded=[];

	protected $table='roles';

	public $timestamps=false;

	public const group_member=1;

	public const group_admin=2;

	public const group_owner=3;
}
