<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Messages extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'messages';

    //relations
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }

    //scopes
    public function scopeAuth_receiver($q)
    {
        $q->Where('receiver_id', Auth::id());
    }

    public function scopeAuth_sender($q)
    {
        $q->Where('sender_id', Auth::id());
    }
}
