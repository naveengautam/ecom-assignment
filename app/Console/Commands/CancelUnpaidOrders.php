<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;

class CancelUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-unpaid-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will cancel all the unpaid orders automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Let's check if order is unpaid then it will cancel it automatically.
        $cancelledOrdersCount = Payment::where('status','unpaid')
                                ->update(['status' => 'cancelled']);
        $this->line("Total unpaid orders cancelled: {$cancelledOrdersCount}");                           
        
    }
}
