<?php

namespace App\Jobs;

use App\Models\Group_users;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelPunishJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(Group_users $group_users)
	{
		$start = Carbon::now()->subweek()->startOfDay();
		$end   = Carbon::now()->subweek()->endOfDay();

		$users_ids = $group_users::whereBetween('updated_at', [$start, $end])
			->where('punish', $group_users::punished)->pluck('id')->toArray();

		if ($users_ids != []) {
			$group_users::whereIn('id', $users_ids)->update(['punish' => 0]);
		}
	}
}
