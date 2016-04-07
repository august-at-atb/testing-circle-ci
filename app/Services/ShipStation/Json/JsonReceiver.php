<?php

namespace App\Services\ShipStation\Json;

use App\Contracts\Interfaces\ReceiverInterface;
use App\Services\Curl\CurlService;
use App\Services\ShipStation\Manager;

class JsonReceiver implements ReceiverInterface
{
    protected $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function receive($url)
    {
        $response = $this->manager->callFetcher($url);
        return $response;
    }
}
