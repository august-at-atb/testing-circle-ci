<?php

namespace App\Services\Amazon\Json;

use App\Contracts\Interfaces\SenderInterface;
use App\Services\Curl\CurlService;
use App\Services\Amazon\Json\JsonBuilder;

class JsonSender implements SenderInterface
{
    protected $builder;

    public function __construct(JsonBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function send($data)
    {
        $url = config('services.amazon.api_gateway_order_update_url');

        $jsonData = $this->builder->create($data);

        $ch = new CurlService();
        $ch->setUrl($url)
           ->setReturnTransfer()
           ->setPostFields($jsonData)
           ->setPost(1)
           ->execute();

        $status = $ch->getStatus();

        return $status;
    }

}
