<?php

namespace App\Http\Controllers\Users;

use App\Classes\Notifications\Notifs;
use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\JsonResponse;

class NotificationsController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'verified']);
	}

	//######################################     show_more    #############################
	public function show_more(int $last_notif_id):JsonResponse
	{
		try {
			$notifications = Notifs::get_more($last_notif_id);

			$view = view('users.notifications.show', compact('notifications'))->render();

			return response()->json(['view' => $view]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}

	//######################################     update     #############################
	public function update():JsonResponse
	{
		try {
			$unseen_notifs_ids = Notifs::get_ids();

			Notifications::whereIn('id', $unseen_notifs_ids)->update(['seen' => 1]);

			return response()->json([]);
		} catch (\Exception) {
			return response()->json(['error' => 'something went wrong'], 500);
		}
	}
}
