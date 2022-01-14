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

    

    public function users_in_groups()
    {
        return $this->belongsToMany("App\Models\User",'Group_users','group_id','user_id');
    }

    public function users()
    {
        return $this->belongsTo("App\Models\User",'user_id');
    }

    public function scopeSelection($q)
    {
        return $q->select('name','description','photo','created_at','id','trans_of','trans_lang');
    }
}
