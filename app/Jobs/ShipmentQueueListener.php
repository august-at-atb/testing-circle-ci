<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Services\ShipStation\Json\JsonReceiver;

class ShipmentQueueListener extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $connection = 'aws_sqs_shipped_url';

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct(JsonReceiver $receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * Listens to SQS queue and gets shipment from ShipStation
     *
     * @return void
     */

    public function fire(\Illuminate\Contracts\Queue\Job $job, $data)
    {
        $this->setJob($job);
        try {
            $url = $data['resource_url'];
            $this->receiver->receive($url);
            $this->delete();
            Log::info("Processed shipment URL: $url from Shipped ULR SQS Successfully.");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
