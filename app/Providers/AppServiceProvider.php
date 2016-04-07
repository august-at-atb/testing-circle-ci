<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order\Entities\Order;
use App\Models\Order\Repositories\OrderRepository;
use App\Models\Shipment\Entities\Shipment;
use App\Models\Shipment\Repositories\ShipmentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ShipmentRepository::class, function ($app) {
            return new ShipmentRepository(
                    $app['em'],
                    $app['em']->getClassMetaData(Shipment::class)
            );
        });
        $this->app->bind(OrderRepository::class, function ($app) {
            return new OrderRepository(
                    $app['em'],
                    $app['em']->getClassMetaData(Order::class)
            );
        });
    }
}
