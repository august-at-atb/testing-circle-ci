<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Shipment\Repositories\ShipmentRepository;
use App\Services\ShipStation\Manager;

class ShipStationSend extends Command
{
    protected $shipmentRepo;
    protected $manager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipstation:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Order to ShipStation (Not Synced Sorted by ASC)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ShipmentRepository $shipmentRepo, Manager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->shipmentRepo = $shipmentRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = $this->shipmentRepo->getNextShipments();
        foreach ($orders as $order) {
            $this->manager->callSender($order['order_id']);
        }
    }
}
