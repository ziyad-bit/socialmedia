<?php

namespace Database\Seeders;

use App\Models\Languages;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Languages::create([
			'name'=>'arabic',
			'direction'=>'rtl',
			'abbr'=>'ar',
			'active'=>'1',
		]);

		Languages::create([
			'name'=>'english',
			'direction'=>'ltr',
			'abbr'=>'en',
			'active'=>'1',
		]);

		Languages::create([
			'name'=>'french',
			'direction'=>'ltr',
			'abbr'=>'fr',
			'active'=>'1',
		]);
	}
}
