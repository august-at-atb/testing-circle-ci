<?php

namespace App\Services\Amazon;

use App\Services\Amazon\Json\JsonSender;
use App\Services\Amazon\Json\JsonBuilder;

class Manager
{
    public function callSender($data)
    {
        $sender = new JsonSender(new JsonBuilder);
        $sender->send($data);
    }

}
