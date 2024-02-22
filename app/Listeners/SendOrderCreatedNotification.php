<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        // this is bring the order 
        $order=$event->order;
        // this is the code bring the Store Owner from User uses  order->store_id
        // single user
        $user=User::where('store_id','=',$order->store_id)->first();
       
        // send notification to the Store Owner 
        $user->notify(new OrderCreatedNotification($order));
        
        // multi user notification
        // IF need send more on user
        // $users=User::where('store_id','=',$event->order->store_id)->get();
        // Notification::send($users,new OrderCreatedNotification($event->order));

    }
}
