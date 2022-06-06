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
        $this->middleware(['auth','verified']);
    }

    public function show_more(int $last_notif_id):JsonResponse
    {
        $notifications = Notifs::get($last_notif_id);
                            
        $view=view('users.notifications.show',compact('notifications'))->render();
        return response()->json(['view'=>$view]);
    }

    public function update():JsonResponse
    {
        $unseen_notifs_ids = Notifs::get_ids();

        Notifications::whereIn('id',$unseen_notifs_ids)->update(['seen'=>1]);

        return response()->json([]);
    }
}
