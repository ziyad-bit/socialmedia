<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admins extends Authenticatable
{
    use HasFactory;

    protected $guarded=[];
    protected $table='admins';

    protected $hidden = [
        'password',
    ];

    //mutators
    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = Hash::make($password);
    }
}
