<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_users extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='group_users';

    public $timestamps=false;
}
