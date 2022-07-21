<?php

namespace App\Classes\Notifications;

use App\Models\Notifications;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Notifs
{
	//###########################     get    ###################################
	public static function get():array
	{
		$auth_id = Auth::id();

		if (Cache::has('notifs_' . $auth_id)) {
			$all_notifications = Cache::get('notifs_' . $auth_id);
			$notifs_count      = Cache::get('notifs_count_' . $auth_id);
		} else {
			$notifications = Notifications::selection()->with(['user' => fn ($q) => $q->selection()])
				->where('receiver_id', $auth_id);

			$all_notifications = $notifications->orderByDesc('id')->limit(3)->get();

			$notifs_count = $notifications->where('seen', 0)->count();

			Cache::put('notifs_' . $auth_id, $all_notifications, now()->addHours(2));
			Cache::put('notifs_count_' . $auth_id, $notifs_count, now()->addHours(2));
		}

		return ['all_notifications' => $all_notifications, 'notifs_count' => $notifs_count];
	}

	//###########################     get_more    ###################################
	public static function get_more(int $last_notif_id):Collection
	{
		return Notifications::forAuth()->where('id', '<', $last_notif_id)
			->orderByDesc('id')->limit(3)->get();
	}

	//###########################     get_ids     ###################################
	public static function get_ids():array
	{
		return Notifications::where(['seen' => 0, 'receiver_id' => Auth::id()])->pluck('id')->toArray();
	}
}
