<?php

use App\Services\Spreedly\Json\SpreedlyCore;

class BuildSpreedlyCore extends TestCase
{
    public function setUp()
    {
        $this->transactionToken = 'test token';

        $this->spreedly = $this->getMockBuilder(SpreedlyCore::class)
                               ->disableOriginalConstructor()
                               ->getMock();
    }

    public function test_spreedly_void_transaction()
    {
        $this->spreedly->expects($this->once())
                       ->method('void')
                       ->will($this->returnValue(true));

        $response = $this->spreedly->void($this->transactionToken);
        $this->assertEquals(true, $response);
    }

    public function test_spreedly_refund_full_transaction()
    {
        $this->spreedly->expects($this->once())
                       ->method('refundFull')
                       ->will($this->returnValue(true));

        $response = $this->spreedly->refundFull($this->transactionToken);
        $this->assertEquals(true, $response);
    }

    public function test_spreedly_refund_partial_transaction()
    {
        $this->spreedly->expects($this->once())
                       ->method('refundPartial')
                       ->will($this->returnValue(true));

        $amount = '1000';

        $response = $this->spreedly->refundPartial($this->transactionToken, $amount);
        $this->assertEquals(true, $response);
    }
}
