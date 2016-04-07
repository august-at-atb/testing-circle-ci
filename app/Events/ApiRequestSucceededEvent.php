<?php

namespace App\Events;
use Atypicalbrands\MessageBus\Contracts\SnsEvent;

class ApiRequestSucceededEvent extends SnsEvent{

    //TODO Need to finalize JSON and SNS channels
    public $something = ['somevalue'=> 'asa', 'another_value'=>[
        'sub_array_val'=>1,
        'sub_array_val2'=>2
    ]];

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */

    public function broadcastOn(){
        return ['LEAD_UA_SNS_ORDER_CREATED'];
    }
}
