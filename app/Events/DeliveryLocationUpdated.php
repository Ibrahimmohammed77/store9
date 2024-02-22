<?php

namespace App\Events;

use App\Models\Delivery;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lng;
    public $lat;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($lat,$lng)
    {
        $this->lng = $lng;
        $this->lat = $lat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('deliveries');
    }
    public function broadcastWith()
    {
        return[
            'lng'=>$this->lng,
            'lat'=>$this->lat,
        ];
    }
    public function broadcastAs()
    {
        return 'location-updated';
    }
}
