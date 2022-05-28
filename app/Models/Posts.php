<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='posts';

    #####################################     relations     ##############################
    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Groups','group_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comments','post_id')->orderByDesc('id')->take(4);
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Likes','post_id');
    }

    public function shares()
    {
        return $this->hasMany('App\Models\Shares','post_id');
    }

    #####################################     scopes     ##############################
    public function scopeSelection($q)
    {
        return $q->select('text','id','created_at','user_id','group_id','video','file','photo');
    }
}
