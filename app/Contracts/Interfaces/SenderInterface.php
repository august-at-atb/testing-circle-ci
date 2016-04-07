<?php

namespace App\Contracts\Interfaces;

interface SenderInterface
{
    public function send($shipment);
}
