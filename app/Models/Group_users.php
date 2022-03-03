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

    //status
    public const join_req     = 0;
    public const approved_req = 1;
    public const ignored_req  = 2;

}
