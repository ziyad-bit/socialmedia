<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shares extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='shares';

    public $timestamps=false;

    public function posts()
    {
        return $this->belongsTo('App\Models\Posts','post_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id')->take(50);
    }
}
