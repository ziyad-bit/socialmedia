<?php

namespace App\Events;

use App\Models\Groups;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreGroupOwner
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $group;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $group_id)
    {
        $this->group=$group_id;
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
