<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ReceiveReqNotify implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public string $user_name;

	public string $user_photo;

	public int $receiver_id;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(int $receiver_id)
	{
		$user = Auth::user();

		$this->user_name   = $user->name;
		$this->user_photo  = $user->photo;
		$this->receiver_id = $receiver_id;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('receive_req.' . $this->receiver_id);
	}
}
