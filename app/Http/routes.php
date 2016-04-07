<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['namespace' => 'App\\Http\\Controllers'], function () use ($app){
    $app->get('/atypical.selftest', 'ExampleController@index');
});

$app->group(['prefix' => 'v1/payment', 'namespace' => 'App\\Http\\Controllers'], function () use ($app){
    $app->post('/void', 'PaymentApiController@void');
    $app->post('/refund/full', 'PaymentApiController@refundFull');
    $app->post('/refund/partial', 'PaymentApiController@refundPartial');
});
