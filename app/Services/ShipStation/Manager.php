<?php

namespace App\Services\ShipStation;

use App\Models\Order\Repositories\OrderRepository;
use App\Models\Shipment\Repositories\ShipmentRepository;
use App\Services\ShipStation\Json\JsonSender;
use App\Services\ShipStation\Json\JsonFetcher;
use App\Services\ShipStation\Json\JsonBuilder;
use App\Services\ShipStation\Json\JsonBuildHelper;
use App\Services\Amazon\Manager as AmazonManager;
use Log;

class Manager
{
    protected $shipmentRepo = null;
    protected $orderRepo = null;

    public function __construct(ShipmentRepository $shipmentRepo, OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->shipmentRepo = $shipmentRepo;
    }

    public function callSender($orderId)
    {
        $sender = new JsonSender(new JsonBuilder(new JsonBuildHelper));
        $status = $sender->send($orderId);


        $shipment = $this->shipmentRepo->findOneBy(array('order_id' => $orderId));
        $syncTries = $shipment->getSyncTry() + 1;

        Log::info("Processed syncing order id: $orderId returns $status response from ShipStation. Number of tries: $syncTries");

        if ($status == 200) {
            $status = 1;
        }

        $shipment->setShipStationSynced($status)
                 ->setSyncTry($syncTries);

        $shipment->save();
    }

    public function callFetcher($url)
    {
        $fetcher = new JsonFetcher();
        $response = $fetcher->fetch($url);

        foreach ($response['shipments'] as $shipment) {
            $orderEntity = $this->orderRepo->findOneBy(array('order_number' => $shipment['orderNumber']));
            $orderId = $orderEntity->getId();

            $shipmentEntity = $this->shipmentRepo->findOneBy(array('order_id' => $orderId));

            $shipmentEntity->setShipmentTracking($shipment['trackingNumber'])
                           ->setCarrierCode($shipment['carrierCode'])
                           ->setServiceCode($shipment['serviceCode'])
                           ->setPackageCode($shipment['packageCode'])
                           ->setShipDate($shipment['shipDate']);
            $shipmentEntity->save();

            $orderEntity->setStatus('shipped');
            $orderEntity->save();

            $data = array('order_number' => $shipment['orderNumber'],
                          'tracking_number' => $shipment['trackingNumber'],
                          'carrier_code' => $shipment['carrierCode'],
                          'service_code' => $shipment['serviceCode'],
                          'package_code' => $shipment['packageCode'],
                          'ship_date' => $shipment['shipDate']);

            $amazonManager = new AmazonManager();
            $amazonManager->callSender($data);
        }

        return true;
    }
}
