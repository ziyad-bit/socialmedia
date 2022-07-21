<?php

use App\Models\Languages;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//##############################     languages      ####################################
function default_lang():string
{
	return config('app.locale');
}

function lang_rtl():array
{
	if (Cache::has('langs_abbr')) {
		return Cache::get('langs_abbr');
	}

	$langs_abbr = Languages::where('direction', 'rtl')->pluck('abbr')->toArray();
	Cache::put('langs_abbr', $langs_abbr, now()->addHours(6));

	return $langs_abbr;
}

function getLang()
{
	return LaravelLocalization::setLocale();
}

//##########################         date        ##########################################
function diff_date($date):string
{
	$date_diff = $date->diffInMinutes(date('Y-m-d H:i:s'));
	if ($date_diff == 0) {
		return 'few seconds ago';
	} elseif ($date_diff > 0 && $date_diff < 60) {
		return $date_diff . ' minutes ago';
	} elseif ($date_diff >= 60 && $date_diff < 1440) {
		return number_format($date_diff / 60) . ' hours ago';
	} elseif ($date_diff >= 1440 && $date_diff < 10080) {
		return $date->diffInDays(date('Y-m-d H:i:s')) . ' days ago';
	} elseif ($date_diff >= 10080 && $date_diff < 40320) {
		return $date->diffInWeeks(date('Y-m-d H:i:s')) . ' weeks ago';
	} elseif ($date_diff >= 40320 && $date_diff < 483840) {
		return $date->diffInMonths(date('Y-m-d H:i:s')) . ' months ago';
	} elseif ($date_diff >= 483840) {
		return $date->diffInYears(date('Y-m-d H:i:s')) . ' years ago';
	}
}
