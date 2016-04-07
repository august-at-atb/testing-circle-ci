<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ShipStation\Json\JsonReceiver;
use App\Exceptions\ShipmentSaveFailed;

class ShipStationController extends Controller
{
    protected $receiver;

    public function __construct(JsonReceiver $receiver)
    {
        $this->receiver = $receiver;
    }

    public function shipnotify(Request $request)
    {
        $url = $request->input('resource_url');
        $pattern = 'https://ssapi4.shipstation.com/shipments?storeID=';

        if (str_contains($url, $pattern)) {
            $result = $this->receiver->receive($url);
            if (!$result) {
                throw new ShipmentSaveFailed;
            }
        }
    }
}
