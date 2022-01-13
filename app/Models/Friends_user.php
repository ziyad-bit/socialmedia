<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends_user extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='friend_user';

    public function friends()
    {
        return $this->belongsToMany('app\Models\User','friend_user','friend_id','user_id');
    }
}
