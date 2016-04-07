<?php

use App\Services\ShipStation\Json\JsonReceiver;

class ReceiveJsonShipStationTest extends TestCase
{
    public function setUp()
    {
        $this->receiver = $this->getMockBuilder(JsonReceiver::class)
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->receiver->expects($this->once())
                       ->method('receive')
                       ->will($this->returnValue('200'));
    }

    public function test_receive_url_successful()
    {

        $response = $this->receiver->receive('url');
        $this->assertEquals(200, $response);
    }


}
