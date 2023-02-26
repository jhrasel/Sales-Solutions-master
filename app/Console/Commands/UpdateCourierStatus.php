<?php

namespace App\Console\Commands;

use App\Jobs\UpdateOrderCourierStatus;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateCourierStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courier.status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::query()->where('courier_entry', true)->get();


    }
}
