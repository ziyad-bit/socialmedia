<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Groups extends Model
{
    use HasFactory ,SearchableTrait , Sluggable;

    protected $guarded=[];
    protected $table='groups';

    protected $searchable=[
        'columns'=>[
            'groups.name'        => 10,
            'groups.description' => 7,
        ],
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    ################################    relations    #####################################

    public function group_users()
    {
        return $this->belongsToMany("App\Models\User",'App\Models\Group_users','group_id','user_id')
        ->select('user_id')->as('request')->withPivot('status','id','role_id','punish');
    }

    public function users()
    {
        return $this->belongsTo("App\Models\User",'user_id');
    }

    ################################    scope    #####################################
    public function scopeSelection($q)
    {
        return $q->select('name','description','photo','created_at','id','slug');
    }
}
