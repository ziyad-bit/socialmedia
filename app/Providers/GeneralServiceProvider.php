<?php

namespace App\Providers;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GeneralServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                if (Auth::getDefaultDriver() == 'web') {
                    //get notifications
                    $auth_id   = Auth::id();

                    if (Cache::has('notifs_'.$auth_id)) {
                        $all_notifications = Cache::get('notifs_'.$auth_id);
                        $notifs_count      = Cache::get('notifs_count_'.$auth_id);
                    }else{
                        $notifications = Notifications::selection()->with(['user'=>fn($q)=>$q->selection()])
                        ->where('receiver_id',$auth_id);

                        $all_notifications = $notifications->orderByDesc('id')->limit(3)->get();

                        $notifs_count = $notifications->where('seen',0)->count();

                        Cache::put('notifs_'.$auth_id,$all_notifications,now()->addHours(2));
                        Cache::put('notifs_count_'.$auth_id,$notifs_count,now()->addHours(2));
                    }

                    $view->with(['all_notifications'=>$all_notifications,'notifs_count'=>$notifs_count]);

                    //make user online every request
                    $auth_user = Auth::user();
                    
                    Cache::put('online_user_'.$auth_id,$auth_id,now()->addMinutes(4));
                    
                    if ($auth_user->online == 0) {
                        $auth_user->update(['online'=>1]);
                    }
                }
            }
        });
    }
}
