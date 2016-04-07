<?php

use App\Services\ShipStation\Manager;

class GetShipmentShipStationTest extends TestCase
{
    public function setUp()
    {

        $this->manager = $this->getMockBuilder(Manager::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->manager->expects($this->once())
                      ->method('callFetcher')
                      ->will($this->returnValue(true));
    }

    public function test_get_tracking_number_successful()
    {
        $response = $this->manager->callFetcher('url');
        $this->assertEquals(true, $response);

    }

}
