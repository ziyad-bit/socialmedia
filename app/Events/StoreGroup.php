<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class StoreGroup
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $photo_name;
    public $request;
    public $is_admin;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request ,string $photo_name,bool $is_admin)
    {
        $this->photo_name = $photo_name;
        $this->request    = $request;
        $this->is_admin   = $is_admin;
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
