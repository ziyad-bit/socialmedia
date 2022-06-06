<?php

namespace App\Events;

use App\Models\Password_reset;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatePasswordEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $password;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $email ,string $password)
    {
        $this->email    = $email;
        $this->password = $password;
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
