<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Curl\CurlService;
use Log;

class ShipStationWebHook extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipstation:subscribe:shipnotify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a WebHook to Subscribe to ShipStation';

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
     * @return mixed
     */
    public function handle()
    {
        $url = "https://ssapi.shipstation.com/webhooks/subscribe";
        $apiKey = config('services.shipstation.api_key');
        $apiSecret = config('services.shipstation.api_secret');
        $mimeType = 'Content-Type: application/json';

        $authorization = 'Authorization: Basic '.base64_encode($apiKey.':'.$apiSecret);
        $data = array('target_url' => config('services.shipstation.webhook_target_url'),
                     'event' => 'SHIP_NOTIFY',
                     'store_id' => config('services.shipstation.store'),
                     'friendly_name' => 'Ship Notify Web Hook');

        $jsonDataEncoded = json_encode($data);

        $ch = new CurlService();
        $ch->setUrl($url)
           ->setHttpHeader(array($mimeType, $authorization))
           ->setHeader()
           ->setReturnTransfer()
           ->setPostFields($jsonDataEncoded)
           ->setPost(1);

        $response = $ch->execute();
        Log::info($response);

    }
}
