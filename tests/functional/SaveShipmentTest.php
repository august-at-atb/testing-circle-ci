<?php

use App\Models\Shipment\Entities\Shipment;

class SaveShipmentTest extends TestCase
{
    public function test_save_shipment_successful()
    {
        $testFile = __DIR__."/shipment.json";

        $handle = fopen($testFile, "r");
        $jsonContent = fread($handle, filesize($testFile));

        $jsonData = json_decode($jsonContent,true);

        foreach ($jsonData['shipments'] as $shipmentData) {

            $shipment = new Shipment(app('em'));

            $shipment->setShipmentTracking($shipmentData['trackingNumber'])
                     ->setCarrierCode($shipmentData['carrierCode'])
                     ->setServiceCode($shipmentData['serviceCode'])
                     ->setPackageCode($shipmentData['packageCode'])
                     ->setShipDate($shipmentData['shipDate']);

            $trackingNumber = $shipment->getShipmentTracking();
            
            $this->assertNotNull($trackingNumber);

        }

    }

}
