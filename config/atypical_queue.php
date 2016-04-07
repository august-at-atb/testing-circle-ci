<?php

return [
        'atypical_queue' => [
                'driver'          => 'atypical_sqs',
                'key'             => 'AKIAJFWJCOWGHCJ3SRYA',
                'secret'          => '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',
                'prefix'          => 'https://sqs.us-east-1.amazonaws.com/223455957408',
                'queue'           => 'LEAD_UA_dev_new_order_queue',
                'region'          => 'us-east-1',
                'worker_instance' => '\Atypicalbrands\MessageBus\Workers\SampleWorker@handle'
        ],
];
