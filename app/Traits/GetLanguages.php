<?php

namespace App\Traits;

use App\Models\Groups;
use App\Models\Languages;
use Illuminate\Support\Collection;

trait GetLanguages
{
	//###################################      get_data_in_default_lang      ################################
	public function get_data_in_default_lang(Collection $group):array
	{
		$filter=$group->filter(function ($val) {
			//default_Lang() autoload from app\helpers\general
			return $val['abbr']==default_Lang();
		});

		return array_values($filter->all())[0];
	}

	//###################################      get_data_in_other_langs      ################################
	public function get_data_in_Other_langs(Collection $group):Collection
	{
		return $group->filter(function ($val) {
			//defaultLang() autoload from app\helpers\general
			return $val['abbr']!=default_Lang();
		});
	}

	//###################################      langs_diff      ################################
	public function langs_diff(Groups $group):array
	{
		$languages=Languages::pluck('abbr')->ToArray();
		$group_langs=$group->groups->pluck('trans_lang')->toArray();

		array_push($group_langs, default_lang());
		$lang_diff=array_diff($languages, $group_langs);

		return $lang_diff;
	}
}
