<?php

use App\Services\ShipStation\Json\JsonSender;

class SendJsonShipStationTest extends TestCase
{
    public function setUp()
    {
        $this->sender = $this->getMockBuilder(JsonSender::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->sender->expects($this->once())
                       ->method('send')
                       ->will($this->returnValue(200));
    }

    public function test_sender_send_shipment()
    {

        $response = $this->sender->send('orderId');
        $this->assertEquals(200, $response);

    }


}
