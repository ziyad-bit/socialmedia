<?php

namespace App\View\Composers;

use App\Classes\Notifications\Notifs;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotifsComposer
{
	protected $all_notifications;

	protected $notifs_count;

	public function __construct(Notifs $notifs)
	{
		if (Auth::check()) {
			$notifs = $notifs->get();

			$this->all_notifications = $notifs['all_notifications'];
			$this->notifs_count      = $notifs['notifs_count'];
		}
	}

	/**
	 * Bind data to the view.
	 *
	 * @param  \Illuminate\View\View  $view
	 *
	 * @return void
	 */
	public function compose(View $view)
	{
		$view->with(['all_notifications' => $this->all_notifications, 'notifs_count' => $this->notifs_count]);
	}
}
