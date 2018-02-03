<?php

namespace App\Events;

use App\Models\Dossier;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DossierCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * DossierCreatedEvent constructor.
     * @param Dossier $dossier
     */
    public function __construct(Dossier $dossier)
    {
        \Mail::send('mails.dossiercreated', ['dossier' => $dossier ], function ($message) {
            $message->subject('Nouveau dossier');
            $message->from('crm@partprofinance.ovh', 'PartPro Finance CRM');
            $message->to('descolo.pp@gmail.com');
            $message->cc('partprofinance@gmail.com');
        });
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
