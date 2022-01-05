<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $table='groups';

    public function Groups(){
        return $this->hasMany(self::class,'trans_of');
    }

    public function scopeSelection($q)
    {
        return $q->select('name','description','photo','created_at','id','trans_of');
    }
}
