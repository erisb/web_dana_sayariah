<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

// Investor model
use App\PendanaanAktif;

class UserMonthlyPayEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PendanaanAktif $pendanaan,$amount,$tipe)
    {
        //
        $this->investor = $pendanaan->investor;
        $this->pendanaan = $pendanaan;
        $this->proyek = $pendanaan->proyek;
        $this->total_dana = $pendanaan->total_dana;
        $this->amount = $amount;
        $this->tipe = $tipe;
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
