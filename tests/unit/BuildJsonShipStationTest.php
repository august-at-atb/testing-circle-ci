<?php

use App\Services\ShipStation\Json\JsonBuilder;

class BuildJsonShipStationTest extends TestCase
{
    public function setUp()
    {
        $this->url = 'https://shipstation.com';

        $this->builder = $this->getMockBuilder(JsonBuilder::class)
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->builder->expects($this->once())
                      ->method('create')
                      ->will($this->returnValue('json'));
    }

    public function test_builder_build_successful()
    {
        $response = $this->builder->create('orderId');
        $this->assertNotNull($response);
    }

}
