<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OnlineUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $auth_id   = Auth::id();
            $auth_user = Auth::user();
            
            Cache::put('online_user_'.$auth_id,$auth_id,now()->addMinutes(4));
            if ($auth_user->online == 0) {
                $auth_user->update(['online'=>1]);
            }
        }

        return $next($request);
    }
}
