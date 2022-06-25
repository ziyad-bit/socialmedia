<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreFriendRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiver_id;
    public $req_data;
    public $auth_user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $receiver_id ,array $req_data,array $auth_user)
    {
        $this->receiver_id = $receiver_id;
        $this->req_data    = $req_data;
        $this->auth_user   = $auth_user;
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
