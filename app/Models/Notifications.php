<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifications extends Model
{
    use HasFactory;

    public const all=0;
    public const one=1;

    protected $guarded = [];
    protected $table = 'notifications';


    #####################################     relations     ##############################
    public function user():BelongsTo
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function receiver():BelongsTo
    {
        return $this->belongsTo('App\Models\User','receiver_id');
    }

    #####################################     scope     ##############################
    public function scopeSelection(Builder $q):Builder
    {
        return $q->select('created_at','user_id','seen','id');
    }

    public function scopeForAuth(Builder $query):Builder
    {
        return $query->selection()->with(['user'=>fn($q)=>$q->selection()])
            ->where('receiver_id',Auth::id());
    }
}
