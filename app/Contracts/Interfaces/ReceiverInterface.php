<?php

namespace App\Contracts\Interfaces;

interface ReceiverInterface
{
    public function receive($url);
}
