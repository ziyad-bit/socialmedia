<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function show_more(int $last_notif_id):JsonResponse
    {
        $notifications = Notifications::selection()->with(['user'=>fn($q)=>$q->selection()])
                            ->where('receiver_id',Auth::id())->where('id','<',$last_notif_id)
                            ->orderByDesc('id')->limit(3)->get();
                            
        $view=view('users.notifications.show',compact('notifications'))->render();
        return response()->json(['view'=>$view]);
    }

    public function update():JsonResponse
    {
        $unseen_notifs_ids = Notifications::where(['seen'=>0,'receiver_id'=>Auth::id()])->pluck('id')->toArray();

        Notifications::where('id',$unseen_notifs_ids)->update(['seen'=>1]);

        return response()->json([]);
    }
}
