<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', true);
*/

date_default_timezone_set('America/Los_Angeles');

require_once __DIR__.'/../vendor/autoload.php';

try {
   (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    var_dump($e);
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

/*$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);*/

$app = new Atypicalbrands\MessageBus\LumenApplication(
    realpath(__DIR__.'/../')
);

$app->withFacades();
// $app->withEloquent();


$app->configure('app');
$app->configure('queue');
$app->configure('doctrine');
$app->configure('migrations');
$app->configure('cors');
$app->configure('broadcasting');
$app->configure('services');

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//    App\Http\Middleware\ExampleMiddleware::class
// ]);

 $app->routeMiddleware([
     'auth' => App\Http\Middleware\Authenticate::class,
 ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/


$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);

$app->register(LaravelDoctrine\ORM\DoctrineServiceProvider::class);
$app->register(LaravelDoctrine\Migrations\MigrationsServiceProvider::class);

$app->register(LaravelDoctrine\Extensions\GedmoExtensionsServiceProvider::class);
$app->register(Illuminate\Pagination\PaginationServiceProvider::class);
$app->register(Barryvdh\Cors\LumenServiceProvider::class);

$app->register(Illuminate\Broadcasting\BroadcastServiceProvider::class);
$app->register(Atypicalbrands\MessageBus\MessageBusServiceProvider::class);

/*
 *
 * Register Doctrine Facades
 *
*/

if (!class_exists('EntityManager')) {
    class_alias('LaravelDoctrine\ORM\Facades\EntityManager', 'EntityManager');
}

if (!class_exists('Registry')) {
    class_alias('LaravelDoctrine\ORM\Facades\Registry', 'Registry');

}
if (!class_exists('Doctrine')) {
    class_alias('LaravelDoctrine\ORM\Facades\Doctrine', 'Doctrine');
}

// Doctrine conflicts with Swagger annotation so ignore
Doctrine\Common\Annotations\AnnotationReader::addGlobalIgnoredName('Swagger\Annotations\Info');

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/../app/Http/routes.php';
});

return $app;
