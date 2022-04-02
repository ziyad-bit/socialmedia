<?php

namespace App\Events;

use App\Http\Requests\GroupRequest;
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

    public $request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(GroupRequest $request)
    {
        $this->request=$request;
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
