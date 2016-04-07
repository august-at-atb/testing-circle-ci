<?php

namespace App\Services\ShipStation\Json;

use App\Contracts\Interfaces\FetcherInterface;
use App\Services\Curl\CurlService;

class JsonFetcher implements FetcherInterface
{
    public function fetch($url)
    {
        $apiKey = config('services.shipstation.api_key');
        $apiSecret = config('services.shipstation.api_secret');
        $mimeType = 'Content-Type: application/json';

        $authorization = 'Authorization: Basic '.base64_encode($apiKey.':'.$apiSecret);

        $ch = new CurlService();
        $ch->setUrl($url)
           ->setHttpHeader(array($mimeType, $authorization))
           ->setReturnTransfer();

        $response = $ch->execute();
        $jsonDataDecoded = json_decode($response, true);

        return $jsonDataDecoded;
    }
}
