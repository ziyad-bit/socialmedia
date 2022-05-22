<?php

namespace App\Providers;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
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
                    $notifications=Notifications::selection()->with(['user'=>fn($q)=>$q->selection()])
                        ->where('receiver_id',Auth::id());

                    $all_notifications=$notifications->orderByDesc('id')->limit(3)->get();

                    $notifs_count=$notifications->where('seen',0)->count();

                    $view->with(['all_notifications'=>$all_notifications,'notifs_count'=>$notifs_count]);
                }
            }
        });
    }
}
