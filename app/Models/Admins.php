<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admins extends Authenticatable
{
    use HasFactory;

    protected $guarded=[];
    protected $table='admins';

    protected $hidden = [
        'password',
    ];
}
