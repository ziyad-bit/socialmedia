<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Searches extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='searches';

    #############################    relations   ########################################
    public function users()
    {
        return $this->belongsTo('App/Models/User','user_id');
    }

    #############################    scope   ########################################
    public function scopeSelection($q)
    {
        return $q->select('search','user_id');
    }
}
