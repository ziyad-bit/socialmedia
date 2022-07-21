<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSend implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public string $text;

	public int    $receiver_id;

	public int    $sender_id;

	public string $user_name;

	public string $user_photo;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(array $data, User $user)
	{
		$this->text        = $data['text'];
		$this->receiver_id = $data['receiver_id'];
		$this->sender_id   = $user->id;
		$this->user_name   = $user->name;
		$this->user_photo  = $user->photo;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('chat.' . $this->receiver_id);
	}
}
