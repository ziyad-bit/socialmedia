<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Groups extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $guarded=[];
    protected $table='groups';

    protected $searchable=[
        'columns'=>[
            'groups.name'        => 10,
            'groups.description' => 7,
        ],
    ];
    ################################    relations    #####################################

    public function group_users()
    {
        return $this->belongsToMany("App\Models\User",'Group_users','group_id','user_id')
        ->select('user_id')->as('request')->withPivot('status','id','role_id','punish');
    }

    public function users()
    {
        return $this->belongsTo("App\Models\User",'user_id');
    }

    public function groups()
    {
        return $this->hasMany(self::class,'trans_of');
    }

    ################################    scope    #####################################
    public function scopeSelection($q)
    {
        return $q->select('name','description','photo','created_at','id');
    }

    public function scopeDefaultLang($q)
    {
        return $q->where('trans_lang', default_lang());
    }
}
