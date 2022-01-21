<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SearchableTrait;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $searchable=[
        'columns'=>[
            'users.name'        => 10,
        ],
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #############################    relations   ########################################

    public function friends()
    {
        return $this->belongsToMany(self::class,'friend_user','friend_id','user_id')
            ->withPivot('status');
    }

    public function groups_joined()
    {
        return $this->belongsToMany("App\Models\Groups",'Group_users','user_id','group_id');
    }

    public function searches()
    {
        return $this->hasMany("App\Models\Searches",'user_id');
    }

    public function users()
    {
        return $this->belongsTo('App/Models/User','user_id');
    }

    #############################    scope   ########################################
    public function scopeSelection($q)
    {
        return $q->select('name','work','photo','email','id');
    }

    public function scopeNotAuth($q)
    {
        return $q->where('id','!=',Auth::id());
    }
}
