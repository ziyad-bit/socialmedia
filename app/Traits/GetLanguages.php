<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait GetLanguages
{
    public function getDefault(array $group):array
    {
        $collected_item=collect($group);
        $filter=$collected_item->filter(function($val){
            //default_Lang() autoload from app\helpers\general
            return $val['abbr'] == default_Lang();
        });

        return array_values($filter->all())[0];
    }

    public function getOther(array $group):Collection
    {
        $collected_item=collect($group);
        return $collected_item->filter(function($val){
            //defaultLang() autoload from app\helpers\general
            return $val['abbr'] != default_Lang();
        });
    }
}
