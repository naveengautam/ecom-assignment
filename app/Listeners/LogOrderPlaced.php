<?php

namespace App\Listeners;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Log;

class LogOrderPlaced implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;
        //We can perform any action here since we have $order details.
        Log::info('Order placed event received', [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'vendor_id' => $order->vendor_id,
            'total_price' => $order->total_price,
            'status' => $order->status,
            'occurred_at' => now()->toDateTimeString(),
        ]);
    }
}
