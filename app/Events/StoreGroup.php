<?php

namespace App\Events;

use App\Models\Groups;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class StoreGroup
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $photo_name;
    public $request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request ,string $photo_name)
    {
        $this->photo_name = $photo_name;
        $this->request    = $request;
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
