<?php

namespace App\Console\Commands;

use App\Jobs\CancelPunishJob;
use Illuminate\Console\Command;

class CancelPunish extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cancel:punish';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	
	public function handle():void
	{
		CancelPunishJob::dispatch();
	}
}
