
## Atypical Brands Payment Microservice

### Requirements:

1. Composer https://getcomposer.org/
2. PHP and MySQL in your machine
3. Lumen 5 System Requirements https://lumen.laravel.com/docs/5.2#server-requirements

### Instruction

1. Run "composer install" in the root directory
2. Copy .env.example as .env
3. Add appropriate values for Spreedly Service
ex. SPREEDLY_API_URL=ABC123
4. Generate doctrine proxies "php artisan doctrine:generate:proxies"
5. Run migrations if needed: "php artisan doctrine:migrations:migrate"

### API

void - expects JSON data with transaction_token then calls Spreedly API to void transaction

refund/full - expects JSON data with transaction_token then calls Spreedly API to refund transaction

refund/partial - expects JSON data with transaction_token and amount then calls Spreedly API to partial refund transaction

Notes:
API has swagger doc annotation for possibility of generating swagger doc json file

Service expects API Gateway as a proxy to endpoint

### Events
App\Events\ApiRequestSucceededEvent broadcast to SNS with JSON value
