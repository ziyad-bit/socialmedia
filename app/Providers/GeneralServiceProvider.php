<?php

namespace App\Providers;

use App\View\Composers\NotifsComposer;
use App\View\Composers\OnlineUser;
use Illuminate\Http\Request;
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
		$this->app->singleton(NotifsComposer::class);
		$this->app->singleton(OnlineUser::class);
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot(Request $request)
	{
		if (!request()->is(getLang() . '/admins/*') && !$request->expectsJson()) {
			View::composer('*', NotifsComposer::class);
		}

		if (!request()->is(getLang() . '/admins/*')) {
			View::composer('*', OnlineUser::class);
		}
	}
}
