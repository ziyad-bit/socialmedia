<?php

namespace App\Events;

use App\Models\Group_users;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateGroupOwner
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $group_admin;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Group_users $group_admin)
	{
		$this->group_admin = $group_admin;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('channel-name');
	}
}
