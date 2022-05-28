<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nicolaslopezj\Searchable\SearchableTrait;

class Messages extends Model
{
    use HasFactory , SearchableTrait;

    protected $guarded = [];
    protected $table = 'messages';

    protected $searchable=[
        'columns'=>[
            'users.name'        => 10,
        ],
        'joins' => [
            'users' => ['messages.sender_id','users.id'],
            'users' => ['messages.receiver_id','users.id'],
        ],
    ];

    //relations
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id')->selection();
    }
    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id')->selection();
    }

    //scopes
    public function scopeAuth_receiver(Builder $q):Builder
    {
        return $q->Where('receiver_id', Auth::id());
    }

    public function scopeAuth_sender(Builder $q):Builder
    {
        return $q->Where('sender_id', Auth::id());
    }

    public function scopeSelection(Builder $q):Builder
    {
        return $q->select('id','sender_id','receiver_id','text','created_at');
    }


    public function scopeGetMsgs(Builder $query,int $id):Builder
    {
        return $query->where (fn ($q)=> $q->auth_receiver()->where('sender_id', $id))
            ->orWhere(fn ($q)=> $q->Where('receiver_id', $id)->auth_sender());
    }
}
