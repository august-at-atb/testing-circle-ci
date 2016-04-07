<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'shipstation' => [
       'store' => env('SHIPSTATION_STORE'),
       'api_key' => env('SHIPSTATION_API_KEY'),
       'api_secret' => env('SHIPSTATION_API_SECRET'),
       'webhook_target_url' => env('SHIPSTATION_WEBHOOK_TARGET_URL'),
    ],

    'amazon' => [
       'api_gateway_order_update_url' => env('AWS_API_GATEWAY_ORDER_UPDATE_URL'),
    ],

];
