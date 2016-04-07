<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Driver
    |--------------------------------------------------------------------------
    |
    | The Laravel queue API supports a variety of back-ends via an unified
    | API, giving you convenient access to each back-end using the same
    | syntax for each one. Here you may set the default queue driver.
    |
    | Supported: "null", "sync", "database", "beanstalkd",
    |            "sqs", "redis"
    |
    */

    'default' => env('QUEUE_DRIVER', 'sqs'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'aws_sqs_shipment' => [
            'driver' => 'sqs',
            'key'    => env('AWS_SQS_SHIPMENT_KEY'),
            'secret' => env('AWS_SQS_SHIPMENT_SECRET'),
            'prefix' => env('AWS_SQS_SHIPMENT_PREFIX'),
            'queue'  => env('AWS_SQS_SHIPMENT_NAME'),
            'region' => env('AWS_SQS_SHIPMENT_REGION'),
        ],

        'aws_sqs_shipped_url' => [
            'driver' => 'sqs',
            'key'    => env('AWS_SQS_SHIPPED_URL_KEY'),
            'secret' => env('AWS_SQS_SHIPPED_URL_SECRET'),
            'prefix' => env('AWS_SQS_SHIPPED_URL_PREFIX'),
            'queue'  => env('AWS_SQS_SHIPPED_URL_NAME'),
            'region' => env('AWS_SQS_SHIPPED_URL_REGION'),
        ],

    ],

];
