<?php

namespace App\Events;

use App\Models\TempProspect;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * UserCreateEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $tempProspect = TempProspect::with('processProspect')->where('email', '=', $user->email )->firstOrFail();

        if($tempProspect)
            $tempProspect->processProspect()->delete();
            $tempProspect->delete();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
