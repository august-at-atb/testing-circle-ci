[![Circle CI](https://circleci.com/gh/AtypicalBrandsLLC/atb-custom.ecommerce.shipstation.svg?style=svg&circle-token=a1e75e20667514c813ae4b41b1fbf23b3d4b942c)](https://circleci.com/gh/AtypicalBrandsLLC/atb-custom.ecommerce.shipstation)

### Requirements:

1. Composer https://getcomposer.org/
2. PHP and MySQL in your machine
3. Lumen 5 System Requirements https://lumen.laravel.com/docs/5.2#server-requirements

### Instruction

1. Run "composer install" in the root directory
2. Copy .env.example as .env
3. Add appropriate values for ShipStation Service and AWS SQS Queue
ex. SHIPSTATION_API_KEY=ABC123
4. Add laravel scheduler to cron https://laravel.com/docs/master/scheduling
ShipStation service currently connects to its own database, gets 30 shipments by default every minute and sends to ShipStation API. For failed sync, it will get 10 by default for every 5 minutes. Current max retry is 5.
5. Generate doctrine proxies "php artisan doctrine:generate:proxies"

Note: you can run php artisan command to sync 30 orders by default manually
php artisan shipstation:send / resend for failed sync

Note: to run the queue, you'll need to run a queue listener command ```php artisan queue:listen aws_sqs_shipment``` ```php artisan queue:listen aws_sqs_shipped_url```  and daemonize it with [Forever](https://www.exratione.com/2013/02/nodejs-and-forever-as-a-service-simple-upstart-and-init-scripts-for-ubuntu/) or [Supervisord](http://supervisord.org/installing.html). Please refer to laravel [manual](https://laravel.com/docs/5.2/queues#running-the-queue-listener)

aws_sqs_shipment listener listens to a queue with order data and store to the database
aws_sqs_shipped_url listener listens to a queue with shipment URL from ShipStation

### Process

1. Shipping service aws_sqs_shipment listens to SQS then store order data to database
2. Shipping service scheduler sends data to ShipStation API
3. When we print label in ShipStation, ShipStation sends the shipment URL to SHIPSTATION_WEBHOOK_TARGET_URL
4. Shipping service aws_sqs_shipments listens to SQS then call the shipment URL to get shipment data
5. Shipping service updates its own database and sends the shipment data to AWS_API_GATEWAY_ORDER_UPDATE_URL
