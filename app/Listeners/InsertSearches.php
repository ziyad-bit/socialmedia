<?php

namespace App\Listeners;

use App\Events\StoreSearches;
use App\Models\Searches;
use Illuminate\Support\Facades\Auth;

class InsertSearches
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Handle the event.
	 *
	 * @param  \App\Events\StoreSearches  $event
	 *
	 * @return void
	 */
	public function handle(StoreSearches $event)
	{
		Searches::create(['search'=>$event->search, 'user_id'=>Auth::id()]);
	}
}
