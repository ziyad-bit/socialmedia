<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    public const all=0;
    public const one=1;

    protected $guarded = [];
    protected $table = 'notifications';


    #####################################     relations     ##############################
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User','receiver_id');
    }

    #####################################     scope     ##############################
    public function scopeSelection($q)
    {
        return $q->select('created_at','user_id','seen','id');
    }
}
