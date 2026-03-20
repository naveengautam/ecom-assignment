<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PaymentSucceeded;
use Illuminate\Support\Facades\Log;

class LogPaymentSucceeded implements ShouldQueue
{

    /**
     * Handle the event.
     */
    public function handle(PaymentSucceeded $payment): void
    {
        //print_r($event);
        Log::info('Order placed event received', [
            'order' => json_encode($payment),
            'payment' => 'PAID',
            'occurred_at' => now()->toDateTimeString(),
        ]);
    }
}
