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

    'spreedly' => [
       'api_url' => env('SPREEDLY_API_URL'),
       'environment_key' => env('SPREEDLY_ENVIRONMENT_KEY'),
       'access_secret' => env('SPREEDLY_ACCESS_SECRET'),
    ],

];
