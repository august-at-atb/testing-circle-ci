<?php

namespace App\Services\ShipStation\Json;

use App\Contracts\Interfaces\SenderInterface;
use App\Services\Curl\CurlService;
use App\Services\ShipStation\Json\JsonBuilder;

class JsonSender implements SenderInterface
{
    protected $builder;

    public function __construct(JsonBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function send($orderId)
    {
        $url = "https://ssapi.shipstation.com/orders/createorder";
        $apiKey = config('services.shipstation.api_key');
        $apiSecret = config('services.shipstation.api_secret');
        $mimeType = 'Content-Type: application/json';

        $authorization = 'Authorization: Basic '.base64_encode($apiKey.':'.$apiSecret);

        $shipmentData = $this->builder->create($orderId);
        $ch = new CurlService();
        $ch->setUrl($url)
           ->setHttpHeader(array($mimeType, $authorization))
           ->setReturnTransfer()
           ->setPostFields($shipmentData)
           ->setPost(1);

        sleep(1);
        $response = $ch->execute();
        $status = $ch->getStatus();

        return $status;
    }

}
